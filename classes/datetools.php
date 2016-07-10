<?php

// TODO :
// - reimplement endOfWeek 

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
     * Initialize common dates
     * 
     * @internal
     */ 
    private function initCommonDates()
    {
        $this->today         = $this->copy()->format($this->dateFormat);
        // Had to change method names for yesterday() and tomorrow(), see below.
        $this->tomorrow      = $this->copy()->next_day()->format($this->dateFormat);
        $this->yesterday     = $this->copy()->previous_day()->format($this->dateFormat);
        $this->startOfWeek   = $this->copy()->startOfWeek()->format($this->dateFormat);
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
    
    // Method names for yesterday() and tomorrow() had to be changed as they were static
    // So now we can have a value relative to the datetools instance (expected behaviour with initCommonDates)
    // Methods tomorrow() and yesterday() still exist as static method, returning time relative to now.
    // This should ensure backwards-compatibility.

    /**
     * Get tomorrow's date
     * 
     * @return string DateTime
     */
    public function next_day()
    {
        return $this->addDay();
    }

    
    /* Get yesterday's date
     * 
     * @return string DateTime
     */
    public function previous_day()
    {
        return $this->subDay();
    }
}
