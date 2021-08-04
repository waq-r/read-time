<?php
require_once '/var/www/html/read-time/vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use Waqarahmed\ReadTime\ReadTime;

final class ReadTimeTest extends TestCase
{
    /**
     * @var array<string>
     */
    private $translation = [
        'min'     => 'min',
        'minute'  => 'minuto',
        'minutes' => 'minutos',
        'read'    => 'leer',
    ];

    private function generateText(int $repeat = 251): string
    {
        return str_repeat('ad bc ', $repeat);

    }
    public function testStaticFunctionality(): void
    {
        $text           = $this->generateText();
        ReadTime::$text = $text;

        $this->assertSame('2 min read', ReadTime::minRead($text));
        $this->assertSame(502, ReadTime::$wordCount);
        $this->assertSame(2, ReadTime::$minutes);

        $this->assertEquals(['minutes' => 2, 'seconds' => 12], ReadTime::time($text));

    }
    public function testGetArrayJSON(): void
    {
        $expected = [
            'minutes'        => 2,
            'time'           => ['minutes' => 2, 'seconds' => 12],
            'wordCount'      => 502,
            'translation'    => $this->translation,
            'abbreviate'     => true,
            'wordsPerMinute' => 228,
        ];

        $result = new ReadTime($this->generateText(), $this->translation);

        $this->assertEquals($expected, $result->getArray());

        $this->assertEquals(json_encode($expected), $result->getJSON());
    }

    public function testDoTranslations(): void
    {
        $translation2 = [
            'min'     => 'min',
            'minute'  => 'minuto',
            'minutes' => 'minutes',
            'read'    => 'read',
        ];
        $result = new ReadTime($this->generateText(), $this->translation, false, true, null, 228);
        $this->assertEquals($this->translation, $result->translation);
        $result = new ReadTime($this->generateText(), ['minute' => 'minuto', 'xyz' => 'minutos'], false, false, null, 228);
        $this->assertEquals($translation2, $result->translation);

    }

    public function testGetTime(): void
    {
        $result = new ReadTime($this->generateText());
        $this->assertSame('2 min read', $result->getTime());
        $result->abbreviate = false;
        $this->assertSame('2 minutes read', $result->getTime());

        $result = new ReadTime($this->generateText(), ['minute' => 'minuto', 'minutes' => 'minutos', 'read' => 'leer'], false);
        $this->assertSame('2 minutos leer', $result->getTime());

        $result = new ReadTime($this->generateText(), ['minute' => 'دقیقه', 'minutes' => 'دقیقه', 'read' => 'خواندن'], false, true);
        $this->assertSame('خواندن دقیقه 2', $result->getTime());

        $result = new ReadTime($this->generateText(), ['minute' => 'dakika', 'minutes' => 'dakika', 'read' => 'okuman'], false, false, 'tr');
        $this->assertSame('3 dakika okuman', $result->getTime());

    }

}
