<?php

defined('BASEPATH') or exit('No direct script access allowed');

include_once(LIBSPATH . 'pdf/App_pdf.php');

class Client_today_pdf extends App_pdf
{
    protected $scorecard;

    private $scorecard_number;

    public function __construct($scorecard, $staffs, $tag = '')
    {
        //$this->load_language($scorecard->clientid);

        $scorecard                = hooks()->apply_filters('scorecard_html_pdf_data', $scorecard);
        $GLOBALS['scorecard_client_today_pdf'] = $scorecard;
        $GLOBALS['staffs_client_today_pdf'] = $staffs;

        parent::__construct();

        $today = date("z", time());

        $this->tag              = $tag;
        $this->scorecard        = $scorecard;
        $this->staffs           = $staffs;
        $this->scorecard_number = slug_it('scorecard-day-' . $today);

        $this->SetTitle($this->scorecard_number);
    }

    public function prepare()
    {

        $this->set_view_vars([
            'scorecard_number' => $this->scorecard_number,
            'scorecard'        => $this->scorecard,
            'staffs'        => $this->staffs,
        ]);

        return $this->build();
    }

    protected function type()
    {
        return 'scorecard';
    }

    protected function file_path()
    {
        $customPath = APPPATH . 'views/themes/' . active_clients_theme() . '/views/my_client_today_pdf.php';
        $actualPath = module_views_path('scorecards','/admin/scorecards/pdf/client_today_pdf.php');

        if (file_exists($customPath)) {
            $actualPath = $customPath;
        }

        return $actualPath;
    }
}
