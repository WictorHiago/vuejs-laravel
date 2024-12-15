<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $thundercatsNames = [
            'Lion-O', 'Panthro', 'Tygra', 'Cheetara', 'Snarf',
            'WilyKit', 'WilyKat', 'Jaga', 'Bengali', 'Pumyra',
            'Lynx-O', 'Claudus', 'Grune', 'Slithe', 'Vultureman'
        ];

        $narutoNames = [
            'Naruto', 'Sasuke', 'Sakura', 'Kakashi', 'Hinata',
            'Shikamaru', 'Neji', 'Rock Lee', 'Gaara', 'Itachi',
            'Tsunade', 'Jiraiya', 'Orochimaru', 'Minato', 'Kushina'
        ];

        $lastNames = [
            'Uzumaki', 'Uchiha', 'Haruno', 'Hatake', 'Hyuga',
            'Nara', 'Sarutobi', 'Senju', 'Namikaze', 'Thundera',
            'Plun-Darr', 'Sabaku', 'Yamanaka', 'Inuzuka', 'Aburame'
        ];

        // Array para rastrear emails usados
        $usedEmails = [];

        // Gerar 30 usuários
        for ($i = 0; $i < 30; $i++) {
            do {
                // Alternar entre nomes do ThunderCats e Naruto
                $firstName = $i < 15 
                    ? $thundercatsNames[array_rand($thundercatsNames)]
                    : $narutoNames[array_rand($narutoNames)];
                
                $lastName = $lastNames[array_rand($lastNames)];
                $fullName = $firstName . ' ' . $lastName;

                // Criar email baseado no nome
                $baseEmail = Str::slug($firstName) . '.' . Str::slug($lastName);
                $email = $baseEmail . '@ninja.com';
                
                // Se o email já existe, adicionar um número aleatório
                $counter = 1;
                while (in_array($email, $usedEmails)) {
                    $email = $baseEmail . $counter . '@ninja.com';
                    $counter++;
                }
            } while (in_array($email, $usedEmails));

            // Adicionar email à lista de usados
            $usedEmails[] = $email;

            // Gerar CPF único
            $cpf = sprintf('%011d', mt_rand(10000000000, 99999999999));

            DB::table('users')->insert([
                'name' => $fullName,
                'email' => strtolower($email),
                'cpf' => $cpf,
                'password' => Hash::make('password123'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
