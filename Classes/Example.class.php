<?php

class Example
{
    public function showWelcomePage(View $view, array $query, $showDebug = false, $handler = __METHOD__) {
        $request = new Request($_SERVER['REQUEST_URI']);
        $relativePath = str_replace('/microFramework', '', $request->get('path'));

        $view->render('index.php', array(
            'uri' => $relativePath,
            'method' => $handler,
            'query' => $query,
            'info' => $showDebug
        ));
    }

    public function showWithInfo(View $view, array $query) {
    	$this->showWelcomePage($view, $query, true, __METHOD__);
    }
}