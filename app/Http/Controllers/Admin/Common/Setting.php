<?php

namespace App\Http\Controllers\Admin\Common;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Common\Setting as S_model;
use App\Model\Common\Payment_method;
use App\SM\SM;


class Setting extends Controller
{
    public function index()
    {
        $settings['s_info'] = S_model::all();

        return view('nptl-admin/common/setting/setting', $settings);
    }

    public function save_setting(Request $data)
    {
        $this->validate($data, [
            'site_name' => 'required',
            'website' => 'required',
            'address' => 'required',
            'country' => 'required',
            'email' => 'required|email',
            'secondary_email' => 'required|email',
            'mobile' => 'required',
            'about' => 'required',
            'currency' => 'required',
        ]);

        $this->update_setting('site_name', $data['site_name']);
        $this->update_setting('website', $data['website']);
        $this->update_setting('tag_line', $data['tag_line']);
        $this->update_setting('about', $data['about']);
        $this->update_setting('address', $data['address']);
        $this->update_setting('country', $data['country']);
        $this->update_setting('mobile', $data['mobile']);
        $this->update_setting('email', $data['email']);
        $this->update_setting('secondary_email', $data['secondary_email']);
         $this->update_setting('currency', $data['currency']);
        $this->update_setting('primary_color', $data['primary_color']);
        $this->update_setting('secondary_color', $data['secondary_color']);
        if (isset($data['favicon']) && $data['favicon'] != '') {
            $this->update_setting('favicon', $data['favicon']);
        }
        if (isset($data['logo']) && $data['logo'] != '') {
            $this->update_setting('logo', $data['logo']);
        }

        return back()->with('s_message', 'Site setting successfully saved!');
    }

    public function save_maintenance_setting(Request $data)
    {
        $this->validate($data, [
            'is_maintenance_enable' => 'required',
            'maintenance_title' => 'required',
            'maintenance_description' => 'required',
            'when_site_will_live' => 'required',
        ]);

        $this->update_setting('is_maintenance_enable', $data['is_maintenance_enable']);
        $this->update_setting('maintenance_title', $data['maintenance_title']);
        $this->update_setting('maintenance_description', $data['maintenance_description']);
        $this->update_setting('when_site_will_live', $data['when_site_will_live']);

        return back()->with('s_message', 'Maintenance mode info saved successfully!');
    }

    public function save_tax_setting(Request $data)
    {
        $this->validate($data, [
            'default_tax' => 'required',
            'default_tax_type' => 'required'
        ]);
        $this->update_setting('is_tax_enable', $data['is_tax_enable']);
        $this->update_setting('default_tax', $data['default_tax']);
        $this->update_setting('default_tax_type', $data['default_tax_type']);

        return back()->with('s_message', 'Tax Info Successfully Saved!');
    }

    public function save_cache_setting(Request $data)
    {
        $this->validate($data, [
            'is_cache_enable' => 'required',
            'cache_update_time' => 'required'
        ]);
        $this->update_setting('is_cache_enable', $data['is_cache_enable']);
        $this->update_setting('cache_update_time', $data['cache_update_time']);

        return back()->with('s_message', 'Cache Setting Successfully Saved!');
    }

    public function social()
    {
        return view('nptl-admin/common/setting/social_setting');
    }

    private function update_setting($option_name, $option_value)
    {
        SM::update_setting($option_name, $option_value);
    }

    public function save_meta_info(Request $data)
    {
        $this->validate($data, [
            'site_screenshot' => 'required',
            'site_meta_keywords' => 'max:160',
            'seo_title' => 'max:70',
            'site_meta_description' => 'max:215'
        ]);
        $site_screenshot = isset($data['site_screenshot']) ? $data['site_screenshot'] : null;
        $this->update_setting('site_screenshot', $site_screenshot);

        $seo_title = isset($data['seo_title']) ? $data['seo_title'] : null;
        $this->update_setting('seo_title', $seo_title);

        $site_meta_keywords = isset($data['site_meta_keywords']) ? $data['site_meta_keywords'] : null;
        $this->update_setting('site_meta_keywords', $site_meta_keywords);

        $site_meta_description = isset($data['site_meta_description']) ? $data['site_meta_description'] : null;
        $this->update_setting('site_meta_description', $site_meta_description);

        return back()->with('s_message', 'Site meta info updated successfully!');
    }

    public function save_fb_credential(Request $data)
    {
        $this->validate($data, [
            'fb_app_id' => 'required',
            'fb_app_secret' => 'required',
        ]);
        if (isset($data['fb_api_enable']) && $data['fb_api_enable'] == 'on') {
            $this->update_setting('fb_api_enable', 'on');
        } else {
            $this->update_setting('fb_api_enable', 'off');
        }
        $this->update_setting('fb_app_id', $data['fb_app_id']);
        $this->update_setting('fb_app_secret', $data['fb_app_secret']);

        return back()->with('s_message', 'Facebook Credential successfully saved!');
    }

    public function save_gp_credential(Request $data)
    {
        $this->validate($data, [
            'gp_client_id' => 'required',
            'gp_client_secret' => 'required',
        ]);
        if (isset($data['gp_api_enable']) && $data['gp_api_enable'] == 'on') {
            $this->update_setting('gp_api_enable', 'on');
        } else {
            $this->update_setting('gp_api_enable', 'off');
        }
        $this->update_setting('gp_client_id', $data['gp_client_id']);
        $this->update_setting('gp_client_secret', $data['gp_client_secret']);

        return back()->with('s_message', 'Google Credential successfully saved!');
    }

    public function save_li_credential(Request $data)
    {
        $this->validate($data, [
            'li_client_id' => 'required',
            'li_client_secret' => 'required',
        ]);
        if (isset($data['li_api_enable']) && $data['li_api_enable'] == 'on') {
            $this->update_setting('li_api_enable', 'on');
        } else {
            $this->update_setting('li_api_enable', 'off');
        }
        $this->update_setting('li_client_id', $data['li_client_id']);
        $this->update_setting('li_client_secret', $data['li_client_secret']);

        return back()->with('s_message', 'Linkedin Credential successfully saved!');
    }

    public function save_tt_credential(Request $data)
    {
        $this->validate($data, [
            'tt_api_key' => 'required',
            'tt_api_secret' => 'required'
        ]);
        if (isset($data['tt_api_enable']) && $data['tt_api_enable'] == 'on') {
            $this->update_setting('tt_api_enable', 'on');
        } else {
            $this->update_setting('tt_api_enable', 'off');
        }
        $this->update_setting('tt_api_key', $data['tt_api_key']);
        $this->update_setting('tt_api_secret', $data['tt_api_secret']);

        return back()->with('s_message', 'Twitter Credential successfully saved!');
    }

}
