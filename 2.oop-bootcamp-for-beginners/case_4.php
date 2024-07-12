<?php
class Student {
    public $name;
    public $group;
    public $grade;

    public function __construct(string $name, string $group, float $grade) {
        $this->name = $name;
        $this->group = $group;
        $this->grade = $grade;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getGroup(): string {
        return $this->group;
    }

    public function setGroup(string $group): void
    {
        $this->group = $group;
    }

    public function getGrade(): float {
        return $this->grade;
    }
}

class ContentManager {
    public $students = [];

    public function addStudent(Student $student): void {
        $this->students[] = $student;
    }

    public function displayAllStudents(): void {
        echo "<table border='1'>";
        echo "<tr><th>Name</th><th>Group</th><th>Grade</th></tr>";
        foreach ($this->students as $student) {
            echo "<tr>";
            echo "<td>" . $student->getName() . "</td>";
            echo "<td>" . $student->getGroup() . "</td>";
            echo "<td>" . $student->getGrade() . "</td>";
            echo "</tr>";
        }
        echo "</table><br>";
    }

    public function changeGroupByName(string $name, string $newGroup): void {
        foreach ($this->students as $student) {
            if ($student->getName() === $name) {
                $student->setGroup($newGroup);
                return; 
            }
        }
    }

    public function getGradesByGroup(string $group): array {
        $grades = [];
        foreach ($this->students as $student) {
            if ($student->getGroup() === $group) {
                $grades[] = $student->getGrade();
            }
        }
        return $grades;
    }

    public function calculateAverage(array $grades): float {
        if (count($grades) === 0) {
            return 0; // Avoid division by zero
        }
        return array_sum($grades) / count($grades);
    }

    public function getAverageGradeForGroup(string $group): float {
        $grades = $this->getGradesByGroup($group);
        return $this->calculateAverage($grades);
    }

}

$contentManager = new ContentManager();

$studentData = [
    ['Alice', 'A', 8],
    ['Bob', 'A', 7],
    ['Charlie', 'A', 9],
    ['David', 'A', 6],
    ['Eve', 'A', 8],
    ['Frank', 'A', 7],
    ['Grace', 'A', 9],
    ['Helen', 'A', 6],
    ['Isaac', 'A', 8],
    ['Jack', 'A', 7],
    ['Kate', 'B', 9],
    ['Leo', 'B', 6],
    ['Mary', 'B', 8],
    ['Nathan', 'B', 7],
    ['Olivia', 'B', 9],
    ['Peter', 'B', 6],
    ['Quinn', 'B', 8],
    ['Rachel', 'B', 7],
    ['Simon', 'B', 9],
    ['Tina', 'B', 6],
];

foreach ($studentData as $data) {
    $contentManager->addStudent(new Student($data[0], $data[1], $data[2]));
}

$contentManager->changeGroupByName('Grace', 'B');
$contentManager->changeGroupByName('Tina', 'A');

$contentManager->displayAllStudents();

$moyenneA = $contentManager->getAverageGradeForGroup('A');
$moyenneB = $contentManager->getAverageGradeForGroup('B');

echo "Moyenne Groupe A : " . $moyenneA . "<br>";
echo "Moyenne Groupe B : " . $moyenneB;


?>
