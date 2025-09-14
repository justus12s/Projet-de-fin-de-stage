<?php
namespace App\Controllers;

use App\Models\SettingsModel;
use App\Models\UserModel;
use App\Models\BookModel;

class SettingsController extends BaseController
{
    protected $settingsModel;
    protected $userModel;
    protected $bookModel;

    public function __construct()
    {
        $this->settingsModel = new SettingsModel();
        $this->userModel = new UserModel();
        $this->bookModel = new BookModel();
    }

    public function index()
    {
        $settings = $this->settingsModel->getSettings();
        
        $data = [
            'page_title' => 'Paramètres du Système',
            'settings' => $settings,
            'userCount' => $this->userModel->countAll(),
            'bookCount' => $this->bookModel->countAll()
        ];

        return view('dashboard/section_settings', $data);
    }
    
    public function save()
    {
        $postData = $this->request->getPost();
        
        foreach ($postData as $key => $value) {
            if (strpos($key, 'setting_') === 0) {
                $settingKey = substr($key, 8); // Enlève le préfixe "setting_"
                $this->settingsModel->updateSetting($settingKey, $value);
            }
        }
        
        return redirect()->to('/admin/dashboard/settings')->with('success', 'Paramètres mis à jour avec succès !');
    }
}