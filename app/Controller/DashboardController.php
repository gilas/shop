<?php
/**
 * DashboardController
 *      This is home page for all users
 * @package Insurance
 * @author Hamid
 * @copyright 2012
 * @version $Id$
 * @access public
 */
class DashboardController extends AppController{
    var $uses = false;
    public function index(){}
    public function admin_index(){
        $obj = $this->loadController('Users');
        $this->set('usersCount', $obj->_getStatistics('ALL_USER_COUNT')); 
        
        $obj = $this->loadController('Mosques');
        $this->set('mosquesCount', $obj->_getStatistics('ALL_MOSQUE_COUNT'));
        $this->set('givedMosquesCount', $obj->_getStatistics('GIVED_MOSQUE_COUNT')); 
        
        $obj = $this->loadController('Cars');
        $this->set('carsCount', $obj->_getStatistics('ALL_CAR_COUNT'));
        $this->set('givedCarsCount', $obj->_getStatistics('GIVED_CAR_COUNT')); 
        
        $obj = $this->loadController('Remedies');
        $this->set('remediesCount', $obj->_getStatistics('ALL_REMEDY_COUNT'));
    }
    public function agent_index(){}
    public function admin_insurance(){}
    
    /**
     * This page is homepage for person in agent profile
     * 
     * @return void
     */
    public function userDashboard(){
        $this->_checkPerson();
    }
    
}