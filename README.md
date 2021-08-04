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
$text = str_repeat('ad bc ', 251); //502 words in $text
echo ReadTime::minRead($text);
```
The output:

`2 min read`

### time()
`time()` method returns an array of the number of `minutes` and `seconds` required to read the given $text.
```php
$text = str_repeat('ad bc ', 251); //502 words in $text
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
  string $language = null,
  int $wordsPerMinute = 228
  )
  ```
  #### Class defaults
  - `$wordsPerMinute` default value is `200`
  - `$rtl` language direction right-to-left is `false` by default
  - `$translation` default is `null` class outputs the English language by default
  - `$abbreviate` Abbreviate the word 'minute/minutes' to 'min' is `true` by default


### getTime()
After initiating a new class object, call the `getTime()` method to get the result.
Example:
`4 minutes read` or `1 minute read` or abbreviated `4 min read`.

### setTextLanguge()
Reading time of different languages vary significantly (S. Klosinski,  K. Dietz). Class method setTextLanguage() has estimated reading times of 17 languages taken from this study.

Reference: "Standardized Assessment of Reading Performance: The New International Reading Speed Texts IReST"

#### Language (iso-code) Words-per-minutes
Arabic (ar) 138, Chinese (zh) 158, Dutch (nl) 202, English (en) 228, Finnish (fi) 161, French (fr) 195, German (el) 179, Hebrew (he) 187, Italian (it) 188, Japanese (jp) 193, Polish (pl) 166, Portoguese (pt) 181, Russian (ru) 184, Slovenian (sl) 180, Spanish (es) 218, Swedish (sv) 199, Turkish (tr) 166.

English is the default language. Set different languages by passing two letters (ISO 639-1) language codes to the setTextLanguag() method. 

An example: Setting Turkish as the input language.
 ```php
 $text = str_repeat('ad bc ', 251); //502 words in $text
 $result = new ReadTime($this->generateText(), ['minute' => 'dakika', 'minutes' => 'dakika', 'read' => 'okuman'], false, false, 'tr');
 echo $result->getTime();
 ```

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
$text = str_repeat('ad bc ', 251); //502 words in $text
$result = new ReadTime($this->generateText(), ['minute' => 'minuto', 'minutes' => 'minutos', 'read' => 'leer'], false);
echo $result->getTime();
```
The Spanish translated output: `2 minutos leer`.

#### Right-to-Left Language Translation
Set `$rtl` property to `true` and pass `$translation` of languages written right-to-left.
```php
$text = str_repeat('ad bc ', 251);
$result = new ReadTime($this->generateText(), ['minute' => 'دقیقه', 'minutes' => 'دقایق', 'read' => 'خواندن'], false, true);
echo $result->getTime();
```
Persian translated output: `'خواندن دقایق 2'`

### getJSON()
Method to get JSON output of claculated read time and class properties.

A class instance with default properties outputs:
```php
$text = str_repeat('hello world ', 251);
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
    "wordCount": 502,
    "translation": {
        "min": "min",
        "minute": "minute",
        "minutes": "minutes",
        "read": "read"
    },
    "abbreviate": true,
    "wordsPerMinute": 228
}
```

### getArray()
Method to get array output of calculated read time and instance properties.
A class instance with default properties:
```php
$text = str_repeat('hello world ', 251);
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
  int(502)
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
  int(228)
}
```











