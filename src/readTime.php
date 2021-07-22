<?php
namespace Waqarahmed\ReadTime;

use Exception;

/**
 * Class ReadTime
 * @author Waqar Ahmed <waqar.ahmed@myport.ac.uk>
 */

class ReadTime
{
    /**
     * The text content to calculate the read time.
     * @var string
     */
    public static $text;

    /**
     * Number of words read in a minute.
     * @var int
     */
    public static $wordsPerMinute = 200;

    /**
     * Total words present in the text content.
     * @var int
     */
    public static $wordCount;

    /**
     * Abbreviate minutes in output string to 'min'.
     * @var bool
     */
    public $abbreviate;

    /**
     * Number of minutes required to read text(rounded, minimum 1).
     * @var int
     */
    public static $minutes;

    /**
     * Number of minutes + seconds required to read the text.
     * Minutes are not rounded and there's no minimum value.
     * @var array
     */
    public static $time;

    /**
     * English words with their translations. Default English language values.
     * @var array
     */
    public $translation = [
        'min'     => 'min',
        'minute'  => 'minute',
        'minutes' => 'minutes',
        'read'    => 'read',
    ];

    /**
     * Whether translation language used is written right to left.
     * @var bool
     */
    public $rtl = false;

    public function __construct($text, $translation = null, $abbreviate = true, $rtl = false, $wordsPerMinute = 200)
    {
        self::$text = $text;
        if (isset($translation)) {
            $this->doTranslations($translation);
        }
        self::$wordsPerMinute = $wordsPerMinute;
        $this->abbreviate     = $abbreviate;
        $this->rtl            = $rtl;
    }

    /**
     * Count the number of words in given text content.
     *
     * @param string $text The text content.
     * @return int value of number of words in $text.
     */
    public static function wordCount(): int
    {
        $text            = strip_tags(self::$text);
        self::$wordCount = preg_match_all('/\s+/', $text, $matches);
        return self::$wordCount;
    }
    /**
     * Calculate minutes to read the given text content.
     *
     * @param string $text The text content.
     * @return int value of the number of the minutes required to read text.
     */
    public static function time(string $text): array
    {
        $time                  = self::wordCount($text) / self::$wordsPerMinute;
        self::$time['minutes'] = (int) $time;
        self::$time['seconds'] = ($time * 60) % 60;
        return self::$time;

    }

    /**
     * Calculate time in minute, minimum 1 and rounded.
     *
     * @return void
     */

    protected function roundMinutes(): void
    {
        self::$minutes = (int) max(round(self::wordCount(self::$text) / self::$wordsPerMinute), 1);

    }
    /**
     * Get simple 'x min read' string. Abbrivated, english only.
     *
     * @param string $text The text content.
     * @return string of number of minutes and a message 'minute/s to read'.
     */

    public static function minRead(string $text)
    {
        self::$text = $text;
        self::roundMinutes();
        return self::$minutes . ' min read';
    }

    /**
     * Translate output message string.
     *
     * @param array $translation
     * @return void
     */

    public function doTranslations(array $translation): void
    {
        if (!is_int(key($translation))) {
            foreach ($translation as $key => $value) {
                if (isset($this->translation[$key])) {
                    $this->translation[$key] = $value;
                }
            }
        } else {
            throw new Exception("doTranslations() only accepts an associative array");
        }
    }

    /**
     * Get multi-lingual, abberiviaed/non-abbriviated read time.
     *
     * @return string containg number of minutes and a message, 'x minute/s to read'.
     */

    public function getTime()
    {
        self::roundMinutes();

        if ($this->abbreviate) {
            //return x min read
            return self::$minutes . ' ' . $this->translation['min'] . ' ' . $this->translation['read'];
        } else {
            //return x minute/minutes read
            $output_text = self::$minutes > 1 ? $this->translation['minutes'] : $this->translation['minute'];
            return self::$minutes . ' ' . $output_text . ' ' . $this->translation['read'];
        }
    }

    /**
     * Get an array of class properties and read time data.
     *
     * @return array containg ReadTime class data.
     */

    public function getArray()
    {
        return [
            'minutes'        => self::$minutes,
            'time'           => self::time(self::$text),
            'wordCount'      => self::$wordCount,
            'translation'    => $this->translation,
            'abbreviate'     => $this->abbreviate,
            'wordsPerMinute' => self::$wordsPerMinute,
        ];
    }

    /**
     * Get JSON output of class properties and read time data.
     *
     * @return JSON object of ReadTime class data.
     */

    public function getJSON()
    {
        return json_encode($this->getArray());

    }
}

{

}
