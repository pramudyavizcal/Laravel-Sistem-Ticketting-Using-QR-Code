<?php

namespace Database\Seeders;

use App\Models\Attendee;
use App\Models\Event;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $events = [
            [
                'name' => 'Wisuda Sarjana Universitas Nusantara ' . now()->year,
                'type' => 'wisuda',
                'description' => 'Upacara wisuda program sarjana Universitas Nusantara periode saat ini. Selamat kepada seluruh wisudawan/wisudawati!',
                'venue' => 'Gedung Graha Utama, Universitas Nusantara',
                'event_date' => now()->addMonths(1)->format('Y-m-d'),
                'event_time' => '08:00:00',
                'quota' => 500,
                'organizer' => 'Biro Akademik Universitas Nusantara',
                'theme_color' => '#6C63FF',
                'is_active' => true,
            ],
            [
                'name' => 'Seminar Nasional Teknologi AI ' . now()->addYear()->year,
                'type' => 'seminar',
                'description' => 'Seminar nasional membahas perkembangan Artificial Intelligence dan dampaknya terhadap industri di Indonesia.',
                'venue' => 'Ballroom Hotel Grand Sahara, Jakarta',
                'event_date' => now()->addMonths(2)->format('Y-m-d'),
                'event_time' => '09:00:00',
                'quota' => 300,
                'organizer' => 'Ikatan Ahli Teknologi Indonesia',
                'theme_color' => '#00C9FF',
                'is_active' => true,
            ],
            [
                'name' => 'Konser Musik Nusantara Bersuara',
                'type' => 'konser',
                'description' => 'Konser musik spektakuler menampilkan artis-artis terbaik Indonesia dengan nuansa budaya nusantara.',
                'venue' => 'Jakarta Convention Center',
                'event_date' => now()->addMonths(3)->format('Y-m-d'),
                'event_time' => '19:00:00',
                'quota' => 2000,
                'organizer' => 'Promotor Nusantara Entertainment',
                'theme_color' => '#FF6B6B',
                'is_active' => true,
            ],
            [
                'name' => 'Workshop Laravel & Vue.js',
                'type' => 'workshop',
                'description' => 'Workshop intensif pengembangan web modern menggunakan Laravel dan Vue.js. Tersedia sertifikat kelulusan.',
                'venue' => 'Coworking Space TechHub, Bandung',
                'event_date' => now()->addDays(15)->format('Y-m-d'),
                'event_time' => '08:30:00',
                'quota' => 80,
                'organizer' => 'Komunitas Developer Indonesia',
                'theme_color' => '#43E97B',
                'is_active' => true,
            ],
        ];

        foreach ($events as $eventData) {
            $event = Event::create($eventData);

            // Generate sample attendees
            $sampleAttendees = $this->generateAttendees($event);
            foreach ($sampleAttendees as $att) {
                Attendee::create(array_merge($att, ['event_id' => $event->id, 'ticket_code' => strtoupper(Str::uuid())]));
            }
        }
    }

    private function generateAttendees(Event $event): array
    {
        $names = [
            'Budi Santoso',
            'Siti Rahayu',
            'Ahmad Fauzi',
            'Dewi Lestari',
            'Rizky Pratama',
            'Eka Putri',
            'Fajar Nugroho',
            'Gita Wulandari',
            'Hendra Wijaya',
            'Indah Permata',
        ];
        $types = match ($event->type) {
            'konser' => ['VIP', 'VVIP', 'Regular', 'Backstage'],
            'wisuda' => ['Wisudawan', 'Undangan Keluarga'],
            'seminar' => ['Peserta', 'Pembicara', 'Panitia'],
            'workshop' => ['Peserta', 'Mentor'],
            default => ['Regular'],
        };

        $attendees = [];
        foreach ($names as $i => $name) {
            $attendees[] = [
                'name' => $name,
                'email' => strtolower(str_replace(' ', '.', $name)) . '@email.com',
                'phone' => '08' . rand(10000000, 99999999),
                'seat_number' => strtoupper(chr(65 + ($i % 5))) . '-' . str_pad($i + 1, 3, '0', STR_PAD_LEFT),
                'ticket_type' => $types[$i % count($types)],
                'institution' => match ($event->type) {
                    'wisuda' => 'Universitas Nusantara',
                    'workshop' => 'Freelance Developer',
                    default => 'Umum',
                },
                'faculty' => $event->type === 'wisuda' ? ['Teknik', 'Ekonomi', 'Hukum', 'MIPA', 'Kedokteran'][$i % 5] : null,
                'major' => $event->type === 'wisuda' ? ['Informatika', 'Manajemen', 'Hukum Bisnis', 'Matematika', 'Kedokteran Umum'][$i % 5] : null,
                'is_checked_in' => $i < 4, // First 4 already checked in
                'checked_in_at' => $i < 4 ? now()->subHours(rand(1, 5)) : null,
                'checked_in_by' => $i < 4 ? 'Staff Scanner' : null,
            ];
        }
        return $attendees;
    }
}
