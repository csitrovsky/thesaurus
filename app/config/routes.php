<?php
#   ... [%] ~@
//  ...
\app\core\Router::set('api/thesaurus/search', static function () {

    //  ...
    $thesaurus = new \api\http\Thesaurus();
    echo $thesaurus::engine(
        $class = \api\http\Thesaurus::class
    );

    //  ...
    exit();

});

//  ...
\app\core\Router::set('api/is/logged/in', static function () {

    //  ...
    if (\app\src\Customers::is_logged_in())
    {
        echo json_encode(array(
            'result' => true
        ), JSON_THROW_ON_ERROR);
    } else {
        echo json_encode(array(
            'result' => false
        ), JSON_THROW_ON_ERROR);
    }
    
    //  ...
    exit();
    
});

//  ...
\app\core\Router::set('api/insert/reaction/for/stimul', static function () {
    
    //  ...
    $experimentation = new \api\http\Experimentation();
    echo $experimentation::engine(
        $class = \api\http\Experimentation::class
    );
    
    //  ...
    exit();
    
});

//  ...
\app\core\Router::set('api/get/stimulus', static function () {
    
    // ... 
    $stimulus = new \api\http\Stimulus();
    echo $stimulus::engine(
        $class = \api\http\Stimulus::class
    );
    
    //  ...
    exit();
    
});

//  ...
\app\core\Router::set('account/create', static function () {
    if (\app\src\Customers::is_logged_in())
    {
        header('location: /session/start');
        exit();
    }
});

//  ...
\app\core\Router::set('account/settings', static function () {
    if (!\app\src\Customers::is_logged_in())
    {
        header('location: /session/start');
        exit();
    }
});

//  ...
\app\core\Router::set('session/start', static function () {
    if (\app\src\Customers::is_logged_in())
    {
        header('location: /');
        exit();
    }
});

//  ...
\app\core\Router::set('session/logout', static function () {
    if (\app\src\Customers::is_logged_in())
    {
        \app\src\Customers::log_off();
    }
    header('location: /session/start');
    exit();
});
