# Read Time

Calculates read time of an article.

## Output string
e.g: 'x min read' or '5 minutes read'.

Multilingual translations support.
- Static method to get simple abbreviated output string in English.
- Static method to get int value of number of minutes required to react the given text.

## Usage
### Static Methods

There are two static methods `minRead(string $text)` and`time(sting $text)`.

#### minRead()
For a simple `x min read` message use this method. It returns a rounded minutes number with a `min read` message.
```php
$text = str_repeat('ad bc ', 2020); //440 words in $text
echo ReadTime::minRead($text);
```
The output:

`2 min read`

#### time()
`time()` method return an array of the number of `minutes` and `seconds` required to read the given $text.
```php
$text = str_repeat('ad bc ', 2020); //440 words in $text
ReadTime::time($text);
```
The output:
```php
['minutes' => 2, 'seconds' => 12]
```

### Class Methods
Create an instsnce of class to use 
- translation
- right-to-left language supoort 
- JSON output
- array output

#### constructor()
Constructor takes and sets these parameters:
```php
public function __construct(
  string $text, 
  array $translation = null, 
  bool $abbreviate = true, 
  bool $rtl = false, 
  int $wordsPerMinute = 200
  )
  ```
  ##### Class defaults
  - `$wordsPerMinute` default value is `200`
  - `$rtl` language direction right-to-left is `false` by default
  - `$translation` default is `null` class outputs English labguage by default
  - `$abbreviate` Abbreviate the word 'minute/minutes' to 'min' is `true` by default

#### getTime()
After initiating a new class object. get





