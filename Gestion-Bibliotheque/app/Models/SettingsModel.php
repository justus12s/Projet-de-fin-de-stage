<?php
namespace App\Models;

use CodeIgniter\Model;

class SettingsModel extends Model
{
    protected $table = 'settings';
    protected $primaryKey = 'id';
    protected $allowedFields = ['setting_key', 'setting_value', 'setting_type', 'category', 'description'];
    
    public function getSettings($category = null)
    {
        $builder = $this->db->table($this->table);
        
        if ($category) {
            $builder->where('category', $category);
        }
        
        $settings = $builder->get()->getResultArray();
        
        $result = [];
        foreach ($settings as $setting) {
            // Convertir selon le type
            switch ($setting['setting_type']) {
                case 'number':
                    $result[$setting['setting_key']] = (int)$setting['setting_value'];
                    break;
                case 'boolean':
                    $result[$setting['setting_key']] = (bool)$setting['setting_value'];
                    break;
                case 'json':
                    $result[$setting['setting_key']] = json_decode($setting['setting_value'], true);
                    break;
                default:
                    $result[$setting['setting_key']] = $setting['setting_value'];
            }
        }
        
        return $result;
    }
    
    public function updateSetting($key, $value)
    {
        $setting = $this->where('setting_key', $key)->first();
        
        if ($setting) {
            return $this->update($setting['id'], ['setting_value' => $value]);
        }
        
        return false;
    }
}


