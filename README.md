# Read Time

Calculates the read time of an article.

### Output string
e.g: `x min read` or `5 minutes read`.

### Features
- Multilingual translations support.
- Static to get simple abbreviated output string in English.
- Static method to get the integer value of the number of minutes required to read the given text.
- Multilingual and right-to-left language support.
- Support for Array output
- Support for JSON output

## Installation
Installation using composer
```bash
composer require waqarahmed/read-time
```
## Usage
### Static Methods

There are two static methods `minRead(string $text)` and`time(sting $text)`.

### minRead()
Use this method for a simple `x min read` message. It returns a rounded minutes number with a `min read` message.

```php
$text = str_repeat('ad bc ', 2020); //440 words in $text
echo ReadTime::minRead($text);
```
The output:

`2 min read`

### time()
`time()` method returns an array of the number of `minutes` and `seconds` required to read the given $text.
```php
$text = str_repeat('ad bc ', 2020); //440 words in $text
ReadTime::time($text);
```
The output:
```php
['minutes' => 2, 'seconds' => 12]
```

### Class Methods
Create an instance of the class to use 
- translation
- right-to-left language support 
- JSON output
- array output

### constructor()
The Constructor takes and sets these parameters:
```php
public function __construct(
  string $text, 
  array $translation = null, 
  bool $abbreviate = true, 
  bool $rtl = false, 
  int $wordsPerMinute = 200
  )
  ```
  #### Class defaults
  - `$wordsPerMinute` default value is `200`
  - `$rtl` language direction right-to-left is `false` by default
  - `$translation` default is `null` class outputs the English language by default
  - `$abbreviate` Abbreviate the word 'minute/minutes' to 'min' is `true` by default
### set_text_languge('en)
After initaating with using this method, it's possible to set the speed of reading
based of the language of text.
The parameter is two character string that according of ISO 639-1 represents a language
and now there are the information of 17 languages like: ar, es, fr, zh, en and etc.
### getTime()
After initiating a new class object, call the `getTime()` method to get the result.
Example:
`4 minutes read` or `1 minute read` or abbreviated `4 min read`.

### Translation
Pass translation array to the class to set the translations of the words: `minute`, `minutes`, `min` and `read`.
A passed array must be an associative array with any number of translation strings.
#### Default property of $translation
```php
$translation = [
        'min'     => 'min',
        'minute'  => 'minute',
        'minutes' => 'minutes',
        'read'    => 'read',
    ];

```
#### Example translation input
```php
$text = str_repeat('ad bc ', 220); //440 words in $text
$result = new ReadTime($this->generateText(), ['minute' => 'minuto', 'minutes' => 'minutos', 'read' => 'leer'], false);
echo $result->getTime();
```
The Spanish translated output: `2 minutos leer`.

#### Right-to-Left Language Translation
Set `$rtl` property to `true` and pass `$translation` of languages written right-to-left.
```php
$text = str_repeat('ad bc ', 2020);
$result = new ReadTime($this->generateText(), ['minute' => 'دقیقه', 'minutes' => 'دقایق', 'read' => 'خواندن'], false, true);
echo $result->getTime();
```
Persian translated output: `'خواندن دقایق 2'`

### getJSON()
Method to get JSON output of claculated read time and class properties.

A class instance with default properties outputs:
```php
$text = str_repeat('hello world ', 220);
$result = new ReadTime($text);
echo $result->getJSON();
```

outputs:
```javascript
{
    "minutes": 2,
    "time": {
        "minutes": 2,
        "seconds": 12
    },
    "wordCount": 440,
    "translation": {
        "min": "min",
        "minute": "minute",
        "minutes": "minutes",
        "read": "read"
    },
    "abbreviate": true,
    "wordsPerMinute": 200
}
```

### getArray()
Method to get array output of calculated read time and instance properties.
A class instance with default properties:
```php
$text = str_repeat('hello world ', 220);
$result = new ReadTime($text);
echo $result->getArray();
```
Outputs:
```php
array(6) {
  ["minutes"]=>
  int(2)
  ["time"]=>
  array(2) {
    ["minutes"]=>
    int(2)
    ["seconds"]=>
    int(12)
  }
  ["wordCount"]=>
  int(440)
  ["translation"]=>
  array(4) {
    ["min"]=>
    string(3) "min"
    ["minute"]=>
    string(6) "minute"
    ["minutes"]=>
    string(7) "minutes"
    ["read"]=>
    string(4) "read"
  }
  ["abbreviate"]=>
  bool(true)
  ["wordsPerMinute"]=>
  int(200)
}
```











