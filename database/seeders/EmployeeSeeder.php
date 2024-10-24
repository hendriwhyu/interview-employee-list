<?php

namespace Database\Seeders;

use App\Models\DetailEmployee;
use App\Models\Employee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Inisialisasi Faker
         $faker = Faker::create();

         // Jumlah pegawai yang ingin dibuat
         $numEmployees = 10;

         for ($i = 1; $i <= $numEmployees; $i++) {
            $employee = Employee::create([
                'name' => $faker->name, // Menggunakan Faker untuk nama
                'email' => $faker->unique()->safeEmail, // Menggunakan Faker untuk email
                'position' => $faker->jobTitle, // Menggunakan Faker untuk posisi pekerjaan
                'phone_number' => '08' . rand(10000000, 99999999), // Menghasilkan nomor telepon acak
                'entry_date' => $faker->dateTimeBetween('-5 year', 'now'), // Menggunakan Faker untuk tanggal masuk
                'photo' => 'https://api.dicebear.com/9.x/identicon/svg?seed='.$faker->name, // Menggunakan API DiceBear untuk URL foto
            ]);

            // Mengisi data di tabel employee_details (detail pegawai)
            DetailEmployee::create([
                'employee_id' => $employee->id,
                'date_of_birth' => $faker->dateTimeBetween('-60 years', '-18 years'), // Tanggal lahir antara 18-60 tahun yang lalu
                'gender' => $faker->randomElement(['male', 'female']), // Jenis kelamin acak
                'address' => $faker->address, // Alamat acak
            ]);
         }
    }
}