# DOM Assertions

WIP: Compare DOMDocuments at node level. Built as a custom PHPUnit assertion.

## Usage

### As a PHPUnit extension

Add the trait to your test class:

```php
class MyClassTest extends TestCase
{
    use DOMDocumentAssertions;
(...)
```

Then pass you DOMDocuments to the assertion:

```php
$this->assertDOMDocumentHasSameStructure($dom1, $dom2);
```

If the documents are not equal, the output in the console will be the differences found

### As a dependency

First create the constraint object. The first parameter is the original DOM and the second one is the Comparator to be used. The default `NodeComparator` compares content, attributes, name, and type of nodes. You can override the functionality by providing a different comparator that implements the `ComparatorInterface`.

```php
$comparator = new DOMDocumentComparator($originalDOM, new NodeComparator());
``` 

The call the `->matches()` function, providing another DOM Document to compare.

```php
$comparator->matches($otherDOM);
```

This function will return a boolean. If the result is `false`, `->errorDifference()` will show more information about the differences.
