<?php

class Example extends Base
{
    public function showWelcomePage(array $query, $showDebug = false, $method = __METHOD__) {
        $request = new Request();
        $relativePath = str_replace(ROOT, '/', $request->get('path'));

        $this->view->render('body.php', array(
            'uri' => $relativePath,
            'method' => $method,
            'query' => $query,
            'info' => $showDebug
        ));
    }

    public function showWithInfo(array $query) {
        $this->showWelcomePage($query, true, __METHOD__);
    }
}