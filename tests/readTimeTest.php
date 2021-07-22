<?php
require_once '/var/www/html/read-time/vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use Waqarahmed\ReadTime\ReadTime as ReadTime;

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

    private function generateText(int $repeat = 220): string
    {
        return str_repeat('ad bc ', $repeat);

    }
    public function testStaticFunctionality(): void
    {
        $text           = $this->generateText();
        ReadTime::$text = $text;

        $this->assertSame('2 min read', ReadTime::minRead($text));
        $this->assertSame(440, ReadTime::$wordCount);
        $this->assertSame(2, ReadTime::$minutes);

        $this->assertEquals(['minutes' => 2, 'seconds' => 12], ReadTime::time($text));

    }
    public function testGetArrayJSON(): void
    {
        $expected = [
            'minutes'        => 2,
            'time'           => ['minutes' => 2, 'seconds' => 12],
            'wordCount'      => 440,
            'translation'    => $this->translation,
            'abbreviate'     => true,
            'wordsPerMinute' => 200,
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
        $result = new ReadTime($this->generateText(), $this->translation, false, true, 200);
        $this->assertEquals($this->translation, $result->translation);
        $result = new ReadTime($this->generateText(), ['minute' => 'minuto', 'xyz' => 'minutos'], false, false, 200);
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

        $result = new ReadTime($this->generateText(), ['minute' => 'دقیقه', 'minutes' => 'دقایق', 'read' => 'خواندن'], false, true);
        $this->assertSame('خواندن دقایق 2', $result->getTime());

    }

}
