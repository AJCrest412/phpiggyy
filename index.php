<?php

$data = "john";
$data[1] = "d";
$a = "$data hello";

// Booleans 
// var_dump((bool) "");             // -> false
// var_dump((bool) "Some Text");    // -> true
// var_dump((bool) "0");         // -> false
// var_dump((bool) "false");        // -> true
// var_dump((bool) 0);              // -> false
// var_dump((bool) 1);              // -> true
// var_dump((bool) -1);             // -> true
// var_dump((bool) null);           // -> false
// var_dump((bool) []);             // -> false
// var_dump((bool) ["hello"]);      // -> true

// Integers
// var_dump((int) false);        // -> 0
// var_dump((integer) true);     // -> 1
// var_dump((int) "-1");         // -> -1
// var_dump((int) "Hello");      // -> 0
// var_dump((int) "12 months");  // -> 12
// var_dump((int) 12.7);         // -> 12
// var_dump((int) null);         // -> 0

// Float
// var_dump((float) false);      // -> 0
// var_dump((float) true);       // -> 1
// var_dump((float) "-1");       // -> -1
// var_dump((float) "Hello");    // -> 0
// var_dump((float) "2.5 Hour"); // -> 2.5
// var_dump((float) null);       // -> 0

// Strings
// var_dump((string) false);     // -> ""
// var_dump((string) true);      // -> "1"
// var_dump((string) 0);         // -> "0"
// var_dump((string) 1.353);     // -> "1.353"
// var_dump((string) []);        // -> "Array"
// var_dump((string) ["John"]);  // -> "Array"
// var_dump((string) null);      // -> ""

// Arrays
// var_dump((array) false);      // -> [false]
// var_dump((array) true);       // -> [true]
// var_dump((array) 0);          // -> [0]
// var_dump((array) 1.353);      // -> [1.353]
// var_dump((array) "John");     // -> ["John"]
// var_dump((array) null);       // -> []

// const a = 10;     //const variables not started by $
// a = 23;
// echo a;
// echo "ajafdf0" . a;
// $x = 9;
// foo()

// function isArmstrongNumber(int $number): bool
// {
//   $digits = str_split((string) $number);
//   $digits = array_map(function ($value) use ($digits) {
//     return $value **= count($digits);
//   }, $digits);
//   $armNum = array_sum($digits);
//   return $armNum == $number;
// }
// echo isArmstrongNumber(9);

class School
{
  private $students = [];

  public function add(string $name, int $grade): void
  {
    $this->students[$grade][] = $name;
  }

  public function grade($grade): array
  {
    return $this->students[$grade] ?? [];
  }

  public function studentsByGradeAlphabetical(): array
  {
    ksort($this->students);

    return array_map(function ($grade) {
      sort($grade);

      return $grade;
    }, $this->students);
  }
}
?>
<!-- <h1>hello<?php echo "jaitn $a"; ?> world</h1> -->