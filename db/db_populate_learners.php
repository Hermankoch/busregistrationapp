<?php
randomLearners('1A', 5);
randomLearners('1B', 5);
randomLearners('2A', 8);
randomLearners('2B', 7);
randomLearners('3A', 5);
randomLearners('3B', 5);

function randomLearners($busStopId, $amount)
{
    $names = ['Alice', 'Bob', 'Charlie', 'Daisy', 'Edward', 'Fiona', 'George', 'Hannah', 'Isaac', 'Jasmine', 'Kyle', 'Linda', 'Michael', 'Nina', 'Oscar', 'Penelope', 'Quincy', 'Rachel'];
    $surnames = ['Williams', 'Jones', 'Brown', 'Davis', 'Miller', 'Wilson', 'Moore', 'Taylor', 'Anderson', 'Thomas', 'Jackson', 'White', 'Harris', 'Martin', 'Thompson', 'Garcia', 'Martinez', 'Robinson'];
    for ($i = 1; $i <= $amount ; $i++) {
        $randomName = $names[array_rand($names)];
        $randomSurname = $surnames[array_rand($surnames)];
        $randomCellphonePrefix = ['063', '072', '083', '073', '082'][array_rand(['063', '072', '083', '073', '082'])];
        $randomCellphone = $randomCellphonePrefix . rand(1000000, 9999999);
        $randomGrade = rand(8, 12);
        importLearner($randomName, $randomSurname, $randomCellphone, $randomGrade, ['columnName'=>'AdminID', 'ID'=>1], $busStopId, $busStopId);
    }
}