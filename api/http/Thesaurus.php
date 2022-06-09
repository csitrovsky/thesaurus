<?php


namespace api\http;


use api\Api;

class Thesaurus extends Api
{

    #   ... [%] ~@
    //  ...
    protected static function get()
    {   #   ... code

        //  ...
        $search_word = '';

        //  ...
        $age_initial = 0;
        $age_final = 100;

        //  ... 'any gender', 'male', 'female', 'a comparison of the sexes'
        $gender = 'any gender';

        //  ...
        $spoken_language = 'null';

        //  ...
        $specialty = 'null';

        //  ... 'by frequency', 'alphabetically'
        $collating = 'by frequency';

        //  ... 'direct search', 'reverse lookup'
        $type = 'direct search';

        //  ...
        $limit = 'null';

        //  ...
        $query = ''; $sort = '';

        //  ...
        $frequency = 0;

        //  ...
        $result = array();

        //  ...
        if (empty($_GET['search_word']))
        {
            return self::response(array(
                'error' => 'Вам нужно добавить search_word'
            ), 500);
        }

        //  ...
        $search_word = $_GET['search_word'];

        //  ...
        if (isset($_GET['age_initial']))
        {
            $age_initial = $_GET['age_initial'];
        }

        //  ...
        if (isset($_GET['age_final']))
        {
            $age_final = $_GET['age_final'];
        }

        //  ...
        if (isset($_GET['gender']))
        {
            $gender = $_GET['gender'];
        }

        //  ...
        if (isset($_GET['spoken_language']))
        {
            $spoken_language = $_GET['spoken_language'];
        }

        //  ...
        if (isset($_GET['specialty']))
        {
            $specialty = $_GET['specialty'];
        }

        //  ...
        if (isset($_GET['collating']))
        {
            $collating = $_GET['collating'];
        }

        //  ...
        if (isset($_GET['type']))
        {
            $type = $_GET['type'];
        }

        //  ...
        if (isset($_GET['limit']))
        {
            $limit = $_GET['limit'];
        }

        //  ...
        if ($age_final > $age_initial)
        {
            $query .= ' AND `birthdate` >= ' . $age_initial
                    . ' AND `birthdate` <= ' . $age_final;
        } else {
            return self::response(array(
                'error' => 'Oops! Ошибка обработки возраста. Начальный возраст не может быть больше, чем конечный возраст'
            ), 200);
        }

        //  ...
        if ($gender !== 'any gender')
        {

            //  ...
            if ($gender === 'male')
            {
                $query .= ' AND `gender` = \'male\'';
            }

            //  ...
            if ($gender === 'female')
            {
                $query .= ' AND `gender` = \'female\'';
            }

            //  ...
            if (\strlen($gender) <= 0 && $gender === '')
            {
                return self::response(array(
                    'error' => 'Oops! Ошибка обработки пола. Возможно, ни один тип не выбран'
                ), 200);
            }

        }

        //  ...
        if ($spoken_language !== 'null')
        {
            $query .= ' AND `spoken_language` = '
                    . self::connect()->quote($spoken_language);
        }

        //  ...
        if ($specialty !== 'null')
        {
            $query .= ' AND `specialty` = '
                    . self::connect()->quote($specialty);
        }

        //  ...
        if ($collating === 'by frequency')
        {
            $sort .= ' ORDER BY frequency DESC, word';
        }

        //  ...
        if ($collating === 'alphabetically')
        {
            $sort .= ' ORDER BY word, frequency DESC';
        }

        //  ...
        if ($limit !== 'null')
        {
            $sort .= ' LIMIT ' . $limit;
        }

        //  ...
        if ($gender === 'a comparison of the sexes')
        {

            //  ...
            if ($type === 'direct search')
            {
                $frequency = self::query('SELECT COUNT(`reaction`) AS frequency FROM `answers`
                    WHERE `motivation` = :search_word' . $query . '
                    GROUP BY `reaction`', array(
                    ':search_word' => $search_word
                ));
            }

            //  ...
            if ($type === 'reverse lookup')
            {
                $frequency = self::query('SELECT COUNT(`motivation`) AS frequency FROM `answers`
                    WHERE `reaction` = :search_word ' . $query . '
                    GROUP BY `motivation`', array(
                    ':search_word' => $search_word
                ));
            }

            //  ...
            if ($frequency >= 0)
            {
                $frequency = 0;
            }

        }

        //  ...
        if ($type === 'direct search')
        {

            //  ...
            $result = self::query('SELECT COUNT(`reaction`) AS frequency, `reaction` AS word FROM `answers` WHERE `motivation` LIKE :search_word AND `reaction` != \'NULL\' ' . $query . ' GROUP BY `reaction` ' . $sort . ';', array(
                ':search_word' => $search_word
            ));

            //  ...
            $rejections = self::query('SELECT COUNT(`id`) AS frequency FROM `answers`WHERE `reaction` IS NULL ' . $query . ' GROUP BY `reaction`;')[0]['frequency'];

            //  ...
            $weight = self::query('SELECT COUNT(`reaction`) AS frequency FROM `answers` WHERE `motivation` LIKE ' . self::connect()->quote($search_word) . ' ' . $query . ';')[0]['frequency'];

        }

        //  ...
        if ($type === 'reverse lookup')
        {

            //  ...
            $result = self::query('SELECT COUNT(`motivation`) AS frequency, `motivation` AS word FROM `answers` WHERE `reaction` LIKE :search_word AND `motivation` != \'NULL\' ' . $query . ' GROUP BY `motivation` ' . $sort . ';', array(
                ':search_word' => $search_word
            ));

            //  ...
            $rejections = self::query('SELECT COUNT(`motivation`) AS frequency FROM `answers` WHERE `motivation` IS NULL ' . $query . ' GROUP BY `motivation`;')[0]['frequency'];

            //  ...
            $weight = self::query('SELECT COUNT(`motivation`) as frequency FROM `answers` WHERE `reaction` LIKE ' . self::connect()->quote($search_word) . ' ' . $query . ';')[0]['frequency'];

        }

        //  ...
        if (!\count($result))
        {
            return self::response(array(
                'error' => 'Oops! Поиск не дал никаких результатов'
            ), 200);
        }

        //  ...
        $rejections = $rejections ?: 0;

        //  ...
        $final_result = array();

        //  ...
        $maximum = 0; $not_equal = 0; $single = 0;

        //  ...
        $various = count($result);

        //  ...
        foreach ($result as $item => $value)
        {
            //  ...
            if ((int)$value['frequency'] === 1)
            {
                $single++;
            }
            //  ...
            $final_result[(int)$value['frequency']][] = $value['word'];
        }

        //  ...
        $description_search_word = self::query('SELECT `description` FROM `dictionary` WHERE `word` LIKE :search_word', array(
            ':search_word' => $search_word
        ));
        if (\count($description_search_word))
        {
            $description = $description_search_word[0]['description'];
        }
        
        //  ...
        if ($type === 'direct search')
        {
            $type = 'результат прямого поиска';
        } else {
            $type = 'результат обратного поиска';
        }

        //  ...
        return self::response(array('count' => $weight, 'description' => $description, 'frequency' => $frequency, 'rejections' => $rejections, 'result' => $final_result, 'single' => $single, 'type' => $type, 'various' => $various), 200);

    }   #   ... encode

    #   ... [%] ~@
    //  ...
    protected static function post()
    {   #   ... code

        //  ...
        return self::response('Post error', 500);

    }   #   ... encode

    #   ... [%] ~@
    //  ...
    protected static function put()
    {   #   ... code

        //   ...
        return self::response('Update error', 400);

    }   #   ... encode

    #   ... [%] ~@
    //  ...
    protected static function delete()
    {   #   ... code

        //   ...
        return self::response('Delete error', 500);

    }   #   ... encode

}
