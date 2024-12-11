<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Pemasukan;
use CodeIgniter\HTTP\ResponseInterface;

class NotifikasiController extends BaseController
{
    public function index()
    {
        $notificationModel = new Pemasukan();

        $notifications = $notificationModel->getNotificationsWithRelations();

        $notificationCount = count($notifications);

        return $this->response->setJSON([
            'count' => $notificationCount,
            'notifications' => $notifications
        ]);
    }
}
