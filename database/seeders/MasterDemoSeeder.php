<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class MasterDemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Starting Master Demo Seeder...');

        // Clear existing data from base seeders
        DB::table('student_resources')->delete();
        DB::table('calendar_events')->delete();
        DB::table('attendances')->delete();
        DB::table('marks')->delete();
        DB::table('exam_records')->delete();
        DB::table('payment_records')->delete();
        DB::table('payments')->delete();
        DB::table('staff_records')->delete();
        DB::table('student_records')->delete();
        DB::table('sections')->delete();
        DB::table('subjects')->delete();
        DB::table('exams')->delete();
        DB::table('grades')->delete();
        DB::table('users')->delete();

        // 1. Create Users (Admins, Teachers, Parents, Accountants, Students)
        $this->createUsers();

        // 2. Create Sections
        $this->createSections();

        // 3. Create Subjects
        $this->createSubjects();

        // 4. Create Exams
        $this->createExams();

        // 5. Create Grades
        $this->createGrades();

        // 6. Create Student Records (link users to classes)
        $this->createStudentRecords();

        // 7. Create Staff Records
        $this->createStaffRecords();

        // 8. Create Payment Structures
        $this->createPayments();

        // 9. Create Payment Records for students
        $this->createPaymentRecords();

        // 10. Create Attendance Records
        $this->createAttendance();

        // 11. Create Marks/Exam Records
        $this->createMarks();

        // 12. Create Calendar Events
        $this->createCalendarEvents();

        // 13. Create Student Resources
        $this->createStudentResources();

        $this->command->info('Master Demo Seeder completed!');
    }

    protected function createUsers()
    {
        $this->command->info('Creating users...');
        DB::table('users')->delete();

        // Admin user
        DB::table('users')->updateOrInsert(
            ['email' => 'admin@school.com'],
            [
                'name' => 'School Admin',
                'username' => 'admin',
                'password' => Hash::make('password'),
                'user_type' => 'super_admin',
                'code' => 'ADMIN001',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // Teachers (10 teachers)
        $teacherSubjects = [
            'Mathematics', 'English', 'Science', 'Social Studies', 'Hindi',
            'Physics', 'Chemistry', 'Biology', 'Computer Science', 'Physical Education'
        ];

        foreach ($teacherSubjects as $index => $subject) {
            DB::table('users')->updateOrInsert(
                ['email' => strtolower($subject) . '@school.com'],
                [
                    'name' => 'Mr. ' . $subject . ' Teacher',
                    'username' => strtolower($subject) . '_teacher',
                    'password' => Hash::make('password'),
                    'user_type' => 'teacher',
                    'code' => 'TCH' . str_pad($index + 1, 3, '0', STR_PAD_LEFT),
                    'email_verified_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        // Parents (15 parents)
        $parentNames = [
            'Rajesh Sharma', 'Priya Patel', 'Amit Kumar', 'Sunita Singh', 'Vikram Gupta',
            'Anita Verma', 'Sanjay Jain', 'Meena Reddy', 'Rakesh Yadav', 'Pooja Agarwal',
            'Deepak Joshi', 'Kavita Nair', 'Arun Malhotra', 'Shweta Iyer', 'Manoj Desai'
        ];

        foreach ($parentNames as $index => $name) {
            DB::table('users')->updateOrInsert(
                ['email' => 'parent' . ($index + 1) . '@school.com'],
                [
                    'name' => $name,
                    'username' => 'parent' . ($index + 1),
                    'password' => Hash::make('password'),
                    'user_type' => 'parent',
                    'code' => 'PAR' . str_pad($index + 1, 3, '0', STR_PAD_LEFT),
                    'email_verified_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        // Students (25 students)
        $studentNames = [
            'Aarav Sharma', 'Diya Patel', 'Arjun Kumar', 'Anaya Singh', 'Rohan Gupta',
            'Isha Verma', 'Aditya Jain', 'Myra Reddy', 'Karan Yadav', 'Kiara Agarwal',
            'Vivaan Joshi', 'Aisha Nair', 'Reyansh Malhotra', 'Saanvi Iyer', 'Atharv Desai',
            'Aanya Bansal', 'Vihaan Mehta', 'Navya Kapoor', 'Dhruv Choudhary', 'Prisha Shah',
            'Krish Rao', 'Riya Bhatia', 'Kabir Saxena', 'Avni Trivedi', 'Dev Patel'
        ];

        foreach ($studentNames as $index => $name) {
            DB::table('users')->updateOrInsert(
                ['email' => 'student' . ($index + 1) . '@school.com'],
                [
                    'name' => $name,
                    'username' => 'student' . ($index + 1),
                    'password' => Hash::make('password'),
                    'user_type' => 'student',
                    'code' => 'STU' . str_pad($index + 1, 3, '0', STR_PAD_LEFT),
                    'email_verified_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        // Accountants (2)
        DB::table('users')->updateOrInsert(
            ['email' => 'accountant1@school.com'],
            [
                'name' => 'Ramesh Accountant',
                'username' => 'accountant1',
                'password' => Hash::make('password'),
                'user_type' => 'accountant',
                'code' => 'ACC001',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        DB::table('users')->updateOrInsert(
            ['email' => 'accountant2@school.com'],
            [
                'name' => 'Suresh Finance',
                'username' => 'accountant2',
                'password' => Hash::make('password'),
                'user_type' => 'accountant',
                'code' => 'ACC002',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // Librarian (1)
        DB::table('users')->updateOrInsert(
            ['email' => 'librarian@school.com'],
            [
                'name' => 'Mrs. Library Manager',
                'username' => 'librarian',
                'password' => Hash::make('password'),
                'user_type' => 'librarian',
                'code' => 'LIB001',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }

    protected function createSections()
    {
        $this->command->info('Creating sections...');
        $classes = DB::table('my_classes')->pluck('id', 'name')->toArray();

        $sectionNames = ['A', 'B', 'C'];
        foreach ($classes as $className => $classId) {
            foreach ($sectionNames as $section) {
                DB::table('sections')->updateOrInsert(
                    ['name' => $className . ' ' . $section, 'my_class_id' => $classId],
                    [
                        'name' => $className . ' ' . $section,
                        'my_class_id' => $classId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }
    }

    protected function createSubjects()
    {
        $this->command->info('Creating subjects...');
        $classes = DB::table('my_classes')->pluck('id', 'name')->toArray();
        $teachers = DB::table('users')->where('user_type', 'teacher')->pluck('id')->toArray();

        $subjectsByClass = [
            'Nursery 1' => ['English Rhymes', 'Numbers', 'Drawing', 'Story Time', 'Play'],
            'Nursery 2' => ['English', 'Maths', 'EVS', 'Drawing', 'Rhymes'],
            'Nursery 3' => ['English', 'Maths', 'EVS', 'Hindi', 'Drawing'],
            'Primary 1' => ['English', 'Mathematics', 'EVS', 'Hindi', 'Computer', 'Art'],
            'Primary 2' => ['English', 'Mathematics', 'EVS', 'Hindi', 'Computer', 'Art'],
            'JSS 2' => ['English', 'Mathematics', 'Science', 'Social Studies', 'Hindi', 'Computer'],
            'JSS 3' => ['English', 'Mathematics', 'Science', 'Social Studies', 'Hindi', 'Computer'],
            'SSS 1' => ['English', 'Mathematics', 'Physics', 'Chemistry', 'Biology', 'Computer Science'],
            'SSS 2' => ['English', 'Mathematics', 'Physics', 'Chemistry', 'Biology', 'Computer Science'],
            'SSS 3' => ['English', 'Mathematics', 'Physics', 'Chemistry', 'Biology', 'Computer Science'],
        ];

        foreach ($subjectsByClass as $className => $subjects) {
            $classId = $classes[$className] ?? null;
            if (!$classId) continue;

            foreach ($subjects as $index => $subject) {
                $teacherId = $teachers[$index % count($teachers)] ?? null;
                DB::table('subjects')->updateOrInsert(
                    ['name' => $subject, 'my_class_id' => $classId],
                    [
                        'name' => $subject,
                        'slug' => Str::slug($subject),
                        'my_class_id' => $classId,
                        'teacher_id' => $teacherId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }
    }

    protected function createExams()
    {
        $this->command->info('Creating exams...');
        $year = '2026-2027';

        $exams = [
            ['name' => 'First Term Exam', 'term' => 1, 'year' => $year],
            ['name' => 'Mid Term Exam', 'term' => 2, 'year' => $year],
            ['name' => 'Final Exam', 'term' => 3, 'year' => $year],
        ];

        foreach ($exams as $exam) {
            DB::table('exams')->updateOrInsert(
                ['name' => $exam['name'], 'year' => $year],
                [
                    'name' => $exam['name'],
                    'term' => $exam['term'],
                    'year' => $exam['year'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }

    protected function createGrades()
    {
        $this->command->info('Creating grades...');
        $grades = [
            ['name' => 'A1', 'mark_from' => 91, 'mark_to' => 100],
            ['name' => 'A2', 'mark_from' => 81, 'mark_to' => 90],
            ['name' => 'B1', 'mark_from' => 71, 'mark_to' => 80],
            ['name' => 'B2', 'mark_from' => 61, 'mark_to' => 70],
            ['name' => 'C1', 'mark_from' => 51, 'mark_to' => 60],
            ['name' => 'C2', 'mark_from' => 41, 'mark_to' => 50],
            ['name' => 'D', 'mark_from' => 33, 'mark_to' => 40],
            ['name' => 'E1', 'mark_from' => 21, 'mark_to' => 32],
            ['name' => 'E2', 'mark_from' => 0, 'mark_to' => 20],
        ];

        foreach ($grades as $grade) {
            DB::table('grades')->updateOrInsert(
                ['name' => $grade['name']],
                array_merge($grade, ['created_at' => now(), 'updated_at' => now()])
            );
        }
    }

    protected function createStudentRecords()
    {
        $this->command->info('Creating student records...');
        $students = DB::table('users')->where('user_type', 'student')->pluck('id')->toArray();
        $parents = DB::table('users')->where('user_type', 'parent')->pluck('id')->toArray();
        $classes = DB::table('my_classes')->pluck('id')->toArray();
        $sections = DB::table('sections')->pluck('id', 'my_class_id')->toArray();

        $currentSession = '2026-2027';
        $sectionGroups = [];
        foreach ($sections as $sectionId => $classId) {
            $sectionGroups[$classId][] = $sectionId;
        }

        foreach ($students as $index => $studentId) {
            $classId = $classes[$index % count($classes)];
            $sectionIds = $sectionGroups[$classId] ?? [$sections[array_rand($sections)]];
            $sectionId = $sectionIds[array_rand($sectionIds)];
            $parentId = $parents[$index % count($parents)];

            DB::table('student_records')->updateOrInsert(
                ['user_id' => $studentId],
                [
                    'user_id' => $studentId,
                    'my_class_id' => $classId,
                    'section_id' => $sectionId,
                    'adm_no' => 'ADM' . str_pad($index + 1, 4, '0', STR_PAD_LEFT),
                    'my_parent_id' => $parentId,
                    'session' => $currentSession,
                    'year_admitted' => '2024',
                    'age' => rand(5, 17),
                    'house' => ['Red', 'Blue', 'Green', 'Yellow'][rand(0, 3)],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }

    protected function createStaffRecords()
    {
        $this->command->info('Creating staff records...');
        $teachers = DB::table('users')->where('user_type', 'teacher')->pluck('id')->toArray();

        foreach ($teachers as $teacherId) {
            DB::table('staff_records')->updateOrInsert(
                ['user_id' => $teacherId],
                [
                    'user_id' => $teacherId,
                    'code' => 'EMP' . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT),
                    'emp_date' => Carbon::now()->subYears(rand(1, 10))->format('Y-m-d'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }

    protected function createPayments()
    {
        $this->command->info('Creating payment structures...');
        $year = '2026-2027';
        $classes = DB::table('my_classes')->pluck('id', 'name')->toArray();

        $feeStructures = [
            'Nursery 1' => ['Tuition Fee' => 5000, 'Activity Fee' => 1000],
            'Nursery 2' => ['Tuition Fee' => 5500, 'Activity Fee' => 1000],
            'Nursery 3' => ['Tuition Fee' => 6000, 'Activity Fee' => 1200],
            'Primary 1' => ['Tuition Fee' => 8000, 'Activity Fee' => 1500, 'Lab Fee' => 1000],
            'Primary 2' => ['Tuition Fee' => 8500, 'Activity Fee' => 1500, 'Lab Fee' => 1000],
            'JSS 2' => ['Tuition Fee' => 12000, 'Activity Fee' => 2000, 'Lab Fee' => 1500],
            'JSS 3' => ['Tuition Fee' => 12500, 'Activity Fee' => 2000, 'Lab Fee' => 1500],
            'SSS 1' => ['Tuition Fee' => 15000, 'Activity Fee' => 2500, 'Lab Fee' => 2000],
            'SSS 2' => ['Tuition Fee' => 15500, 'Activity Fee' => 2500, 'Lab Fee' => 2000],
            'SSS 3' => ['Tuition Fee' => 16000, 'Activity Fee' => 2500, 'Lab Fee' => 2000],
        ];

        foreach ($feeStructures as $className => $fees) {
            $classId = $classes[$className] ?? null;
            if (!$classId) continue;

            foreach ($fees as $feeName => $amount) {
                DB::table('payments')->updateOrInsert(
                    ['title' => $feeName, 'my_class_id' => $classId, 'year' => $year],
                    [
                        'title' => $feeName,
                        'my_class_id' => $classId,
                        'amount' => $amount,
                        'ref_no' => 'REF-' . $feeName . '-' . $classId,
                        'method' => 'cash',
                        'year' => $year,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }
    }

    protected function createPaymentRecords()
    {
        $this->command->info('Creating payment records for students...');
        $students = DB::table('student_records')->pluck('user_id', 'my_class_id')->toArray();
        $payments = DB::table('payments')->pluck('id', 'my_class_id')->toArray();
        $year = '2026-2027';

        foreach ($students as $studentId => $classId) {
            $classPayments = DB::table('payments')->where('my_class_id', $classId)->where('year', $year)->get();
            $generalPayments = DB::table('payments')->whereNull('my_class_id')->where('year', $year)->get();

            foreach ($classPayments as $payment) {
                $amtPaid = rand(0, 1) ? $payment->amount : rand(0, $payment->amount);
                DB::table('payment_records')->updateOrInsert(
                    ['student_id' => $studentId, 'payment_id' => $payment->id, 'year' => $year],
                    [
                        'student_id' => $studentId,
                        'payment_id' => $payment->id,
                        'year' => $year,
                        'amt_paid' => $amtPaid,
                        'balance' => $payment->amount - $amtPaid,
                        'paid' => $amtPaid >= $payment->amount ? 1 : 0,
                        'ref_no' => 'REF' . str_pad(rand(100000, 999999), 6, '0', STR_PAD_LEFT),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }

            foreach ($generalPayments as $payment) {
                $amtPaid = rand(0, 1) ? $payment->amount : rand(0, $payment->amount);
                DB::table('payment_records')->updateOrInsert(
                    ['student_id' => $studentId, 'payment_id' => $payment->id, 'year' => $year],
                    [
                        'student_id' => $studentId,
                        'payment_id' => $payment->id,
                        'year' => $year,
                        'amt_paid' => $amtPaid,
                        'balance' => $payment->amount - $amtPaid,
                        'paid' => $amtPaid >= $payment->amount ? 1 : 0,
                        'ref_no' => 'REF' . str_pad(rand(100000, 999999), 6, '0', STR_PAD_LEFT),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }
    }

    protected function createAttendance()
    {
        $this->command->info('Creating attendance records...');
        $students = DB::table('student_records')->pluck('user_id', 'my_class_id')->toArray();
        $sections = DB::table('sections')->pluck('id', 'my_class_id')->toArray();
        $teachers = DB::table('users')->where('user_type', 'teacher')->pluck('id')->toArray();

        $startDate = Carbon::now()->subDays(30);
        $endDate = Carbon::now();

        foreach ($students as $studentId => $classId) {
            $sectionId = $sections[$classId] ?? 1;
            $teacherId = $teachers[array_rand($teachers)];

            for ($date = $startDate; $date <= $endDate; $date->addDay()) {
                // Skip weekends
                if ($date->isWeekend()) continue;

                // 90% attendance rate
                $status = rand(1, 10) <= 9 ? 'present' : (rand(1, 2) === 1 ? 'absent' : 'late');

                DB::table('attendances')->updateOrInsert(
                    ['student_id' => $studentId, 'attendance_date' => $date->format('Y-m-d')],
                    [
                        'student_id' => $studentId,
                        'my_class_id' => $classId,
                        'section_id' => $sectionId,
                        'attendance_date' => $date->format('Y-m-d'),
                        'status' => $status,
                        'marked_by' => $teacherId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }
    }

    protected function createMarks()
    {
        $this->command->info('Creating marks and exam records...');
        $studentRecords = DB::table('student_records')->get();
        $exams = DB::table('exams')->where('year', '2026-2027')->pluck('id', 'term')->toArray();

        foreach ($studentRecords as $record) {
            $studentId = $record->user_id;
            $classId = $record->my_class_id;
            $sectionId = $record->section_id;

            $classSubjects = DB::table('subjects')->where('my_class_id', $classId)->pluck('id')->toArray();

            foreach ($exams as $term => $examId) {
                foreach ($classSubjects as $subjectId) {
                    // Create marks record
                    $t1 = rand(5, 15);
                    $t2 = rand(5, 15);
                    $exm = rand(20, 60);
                    $tca = $t1 + $t2;
                    $total = $tca + $exm;

                    $grade = DB::table('grades')
                        ->where('mark_from', '<=', $total)
                        ->where('mark_to', '>=', $total)
                        ->first();

                    $texCol = 'tex' . $term;
                    DB::table('marks')->updateOrInsert(
                        ['student_id' => $studentId, 'subject_id' => $subjectId, 'exam_id' => $examId, 'my_class_id' => $classId, 'year' => '2026-2027'],
                        [
                            'student_id' => $studentId,
                            'subject_id' => $subjectId,
                            'exam_id' => $examId,
                            'my_class_id' => $classId,
                            'section_id' => $sectionId,
                            'year' => '2026-2027',
                            't1' => $t1,
                            't2' => $t2,
                            'tca' => $tca,
                            'exm' => $exm,
                            $texCol => $total,
                            'grade_id' => $grade->id ?? null,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]
                    );
                }

                // Create exam record
                $totalMarks = DB::table('marks')
                    ->where('student_id', $studentId)
                    ->where('exam_id', $examId)
                    ->where('year', '2026-2027')
                    ->sum('tex' . $term);

                $subjectCount = DB::table('marks')
                    ->where('student_id', $studentId)
                    ->where('exam_id', $examId)
                    ->where('year', '2026-2027')
                    ->count();

                $avg = $subjectCount > 0 ? round($totalMarks / $subjectCount, 2) : 0;

                DB::table('exam_records')->updateOrInsert(
                    ['student_id' => $studentId, 'exam_id' => $examId, 'my_class_id' => $classId, 'year' => '2026-2027'],
                    [
                        'student_id' => $studentId,
                        'exam_id' => $examId,
                        'my_class_id' => $classId,
                        'section_id' => $sectionId,
                        'year' => '2026-2027',
                        'total' => $totalMarks,
                        'ave' => $avg,
                        'class_ave' => rand(45, 75),
                        'pos' => rand(1, 30),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }
    }

    protected function createCalendarEvents()
    {
        $this->command->info('Creating calendar events...');
        $events = [
            ['Makar Sankranti', '2027-01-14', 'hindu', 'Harvest festival', false],
            ['Republic Day', '2027-01-26', 'gregorian', 'National holiday', true],
            ['Maha Shivaratri', '2027-02-16', 'hindu', 'Night of Shiva', false],
            ['Holi', '2027-03-14', 'hindu', 'Festival of colors', true],
            ['Ram Navami', '2027-04-06', 'hindu', 'Birth of Lord Rama', false],
            ['Mahavir Jayanti', '2027-04-17', 'hindu', 'Birth of Lord Mahavira', false],
            ['Good Friday', '2027-04-02', 'gregorian', 'Christian holiday', true],
            ['Buddha Purnima', '2027-05-12', 'hindu', 'Birth of Buddha', false],
            ['Eid al-Fitr', '2027-05-22', 'gregorian', 'Islamic holiday', true],
            ['Raksha Bandhan', '2027-08-09', 'hindu', 'Bond of protection', false],
            ['Independence Day', '2027-08-15', 'gregorian', 'National holiday', true],
            ['Janmashtami', '2027-08-26', 'hindu', 'Birth of Lord Krishna', false],
            ['Ganesh Chaturthi', '2027-09-06', 'hindu', 'Birth of Lord Ganesha', false],
            ['Gandhi Jayanti', '2027-10-02', 'gregorian', 'Birthday of Mahatma Gandhi', true],
            ['Navratri Begins', '2027-10-03', 'hindu', 'Nine nights of Durga', false],
            ['Dussehra', '2027-10-12', 'hindu', 'Victory of good over evil', true],
            ['Diwali', '2027-10-30', 'hindu', 'Festival of lights', true],
            ['Guru Nanak Jayanti', '2027-11-05', 'hindu', 'Birth of Guru Nanak', false],
            ['Eid al-Adha', '2027-11-28', 'gregorian', 'Islamic holiday', true],
            ['Christmas', '2027-12-25', 'gregorian', 'Birth of Jesus Christ', true],
        ];

        foreach ($events as $event) {
            DB::table('calendar_events')->updateOrInsert(
                ['title' => $event[0], 'event_date' => $event[1]],
                [
                    'title' => $event[0],
                    'event_date' => $event[1],
                    'calendar_type' => $event[2],
                    'description' => $event[3],
                    'is_holiday' => $event[4],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }

    protected function createStudentResources()
    {
        $this->command->info('Creating student resources...');
        $students = DB::table('student_records')->pluck('user_id')->toArray();
        $teachers = DB::table('users')->whereIn('user_type', ['teacher', 'admin', 'super_admin'])->pluck('id')->toArray();

        $resources = [
            ['uniform', 'School Uniform Set', 'UNI-' . rand(1000, 9999)],
            ['textbook', 'Mathematics Textbook', 'TB-MAT-' . rand(100, 999)],
            ['textbook', 'English Reader', 'TB-ENG-' . rand(100, 999)],
            ['textbook', 'Science Textbook', 'TB-SCI-' . rand(100, 999)],
            ['lab_equipment', 'Lab Coat', 'LC-' . rand(1000, 9999)],
            ['lab_equipment', 'Safety Goggles', 'SG-' . rand(1000, 9999)],
            ['sports_equipment', 'Football', 'FB-' . rand(100, 999)],
            ['sports_equipment', 'Cricket Bat', 'CB-' . rand(100, 999)],
            ['certificate', 'Merit Certificate', 'CERT-' . rand(1000, 9999)],
            ['other', 'ID Card', 'ID-' . rand(1000, 9999)],
        ];

        foreach ($students as $studentId) {
            // Each student gets 3-5 resources
            $numResources = rand(3, 5);
            $assignedResources = array_rand($resources, $numResources);

            if (!is_array($assignedResources)) {
                $assignedResources = [$assignedResources];
            }

            foreach ($assignedResources as $resIndex) {
                $resource = $resources[$resIndex];
                $issueDate = Carbon::now()->subDays(rand(0, 60));
                $isReturned = rand(1, 5) === 1; // 20% returned

                DB::table('student_resources')->insert([
                    'student_id' => $studentId,
                    'resource_type' => $resource[0],
                    'resource_name' => $resource[1],
                    'serial_number' => $resource[2],
                    'issue_date' => $issueDate->format('Y-m-d'),
                    'return_date' => $isReturned ? $issueDate->addDays(rand(1, 30))->format('Y-m-d') : null,
                    'status' => $isReturned ? 'returned' : 'issued',
                    'issued_by' => $teachers[array_rand($teachers)],
                    'remarks' => 'Issued for academic session',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}