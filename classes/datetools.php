<?php

// TODO :
// - reimplement tomorrow, yesterday and endOfWeek as they seem to be broken

namespace Grav\Plugin;

require_once __DIR__.'/../vendor/autoload.php';

use Grav\Common\Grav;
use Grav\Common\GravTrait;
use \Carbon\Carbon;
use \Carbon\CarbonInterval;

use DateInterval;
use DateTime;

class DateTools extends Carbon
{
    use GravTrait;

    /**
     * @var object Config
     */ 
    protected $config;

    /**
     * @var string Date format
     */
    protected $dateFormat; 

    /**
     * Various on the fly dates 
     */
    public $today;
	public $tomorrow;
	public $yesterday;
	public $startOfWeek;
	public $endOfWeek;
	public $startOfMonth;
	public $endOfMonth;
	public $startOfYear;
	public $endOfYear;

    /**
     * Construct
     */ 
    public function __construct( $args )
    {
        // get the config
        $this->config = $args['config'];

        // date format
        $this->dateFormat = $this->config->get('plugins.datetools.dateFormat.default');
        
        parent::__construct();
        
        // initialize common dates
        $this->initCommonDates();
    }
    
    /**
     * Copy config on clone
     */    
    public function __clone() {
        $this->config = clone $this->config;
    }

    /**
     * Initialize common dates
     * 
     * @internal
     */ 
    private function initCommonDates()
    {
        $this->today         = $this->copy()->format($this->dateFormat);
        //TODO fix today and tomorrow()
        //$this->tomorrow = $test->tomorrow()->format($test->dateFormat);
        //$this->tomorrow      = $this->copy()->tomorrow()->format($this->dateFormat);
        //$this->yesterday     = $this->copy()->yesterday()->format($this->dateFormat);
        $this->startOfWeek   = $this->copy()->startOfWeek()->format($this->dateFormat);
        //$this->endOfWeek = $this->copy()->endOfWeek();
        //$this->endOfWeek     = $this->copy()->endOfWeek()->format($this->dateFormat);
        $this->startOfMonth  = $this->copy()->startOfMonth()->format($this->dateFormat);
        $this->endOfMonth    = $this->copy()->endOfMonth()->format($this->dateFormat);
        $this->startOfYear   = $this->copy()->startOfYear()->format($this->dateFormat);
        $this->endOfYear     = $this->copy()->endOfYear()->format($this->dateFormat);
    }

    /**
     * Parse a relative date
     *
     * @param string $string Relative Date string
     * @return string DateTime
     */
    public function parseDate($string = null)
    {
        if ($string == null) {
            return null;
        }

        return Carbon::parse($string);
    }
    
    public function copy() {
        return clone $this;
    }
    
    // Begin endless wrappers to reinitialize the variables
    
    /*public function addDay($value = 1) {
        return $this->addDays($value);
    }
    
    public function addDays($value = 1) {
        parent::addDays($value);
        $this->initCommonDates();
        return $this;
    }
    
    public function addWeek($value = 1) {
        return $this->addWeeks($value);
    }
    
    public function addWeeks($value = 1) {
        parent::addWeeks($value);
        $this->initCommonDates();
        return $this;
    }
    
    public function addMonth($value = 1) {
        return $this->addMonths($value);
    }
    
    public function addMonths($value = 1) {
        parent::addMonths($value);
        $this->initCommonDates();
        return $this;
    }
    
    public function addYear($value = 1) {
        return $this->addYears($value);
    }
    
    public function addYears($value = 1) {
        parent::addYears($value);
        $this->initCommontDates();
        return $this;
    }*/
    
    public function modify($modify) {
        $instance = parent::modify($modify);
        $this->initCommonDates();
        return $instance;
    }
    
    /*public function endOfWeek() {
        echo parent::$weekEndsAt - $this->dayOfWeek;
        $instance = $this->addDays(parent::$weekEndsAt - $this->dayOfWeek);
        $this->initCommonDates();
        return $instance;
    }*/
    

    /**
     * Get tomorrow's date
     * 
     * @return string DateTime
     */
    /*public function tomorrow()
    {
        return $this->addDay();
    }
    
    public function yesterday() {
        return $this->addDay(-1);
    }*/

    /**
     * Get yesterday's date
     * 
     * @return string DateTime
     */
    /*public function yesterday()
    {
        return $this->subDay();
    }*/
}
