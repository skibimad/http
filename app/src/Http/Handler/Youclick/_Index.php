<?php

namespace App\Controller\Youclick;

use Juzdy\Controller;

class Index extends Controller
{
    public function handle(): void
    {
        $this->render(
            'youclick',
            [
                'videoUrl' => $this->getRequest('y')
            ],
            true
        );
        //$this->redirect($this->getRequest('y'));
    }
}
