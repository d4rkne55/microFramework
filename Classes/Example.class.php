<?php

class Example extends Base
{
    public function showWelcomePage(array $query, $showDebug = false) {
        $request = new Request($_SERVER['REQUEST_URI']);
        $relativePath = str_replace(ROOT, '/', $request->get('path'));

        $this->view->render('index.php', array(
            'uri' => $relativePath,
            'method' => __METHOD__,
            'query' => $query,
            'info' => $showDebug
        ));
    }

    public function showWithInfo(array $query) {
    	$this->showWelcomePage($query, true);
    }
}