<?php

class CompaniesController extends Controller
{

    private Company $company;

    /**
     *
     */
    function __construct() {
        require(APP_ROOT . '/Models/Company.php');
        $this->company = new Company(COMPANY_NAME, CONNECTIONS, CITIES);
    }

    /**
     *
     */
    function index() {
        $this->set(array('cities' => $this->company->getCities()));
        $this->render('index');
    }

    /**
     *
     */
    function showPaths() {
        $paths = $this->company->getMinimumCostPaths($_POST['origin'], $_POST['destination']);

        $this->set(array(
            'cities' => $this->company->getCities(),
            'paths' => $paths
        ));
        $this->render('show_paths');
    }

}
