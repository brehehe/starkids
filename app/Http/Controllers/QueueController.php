<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class QueueController extends Controller
{
    private function getQueues()
    {
        return session('queues', []);
    }

    private function saveQueues($queues)
    {
        session(['queues' => $queues]);
    }

    private function generateQueueNumber()
    {
        $queues = $this->getQueues();
        $today = now()->format('Y-m-d');

        $todayQueues = array_filter($queues, function($queue) use ($today) {
            return substr($queue['queue_time'], 0, 10) === $today;
        });

        $lastNumber = count($todayQueues);
        return str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
    }

    private function getTodayQueues()
    {
        $queues = $this->getQueues();
        $today = now()->format('Y-m-d');

        return array_filter($queues, function($queue) use ($today) {
            return substr($queue['queue_time'], 0, 10) === $today;
        });
    }

    public function index()
    {
        // Initialize dummy data if no queues exist
        if (!session()->has('queues')) {
            $this->initializeDummyData();
        }

        $queues = session('queues', []);

        // Get today's queues
        $todayQueues = collect($queues)->filter(function ($queue) {
            return \Carbon\Carbon::parse($queue['queue_time'])->isToday();
        })->values()->all();

        // Get current queue (the one being served)
        $currentQueue = collect($queues)->where('status', 'Sedang Dilayani')->first();

        // Count waiting queues
        $waitingCount = collect($queues)->where('status', 'Menunggu')->count();

        return view('queue.index', compact('queues', 'todayQueues', 'currentQueue', 'waitingCount'));
    }

    private function initializeDummyData()
    {
        $dummyQueues = [
            [
                'id' => 'Q001',
                'queue_number' => 'A001',
                'patient_name' => 'Ahmad Rizki',
                'phone_number' => '081234567890',
                'gender' => 'L',
                'age' => 35,
                'complaint' => 'Demam dan batuk sudah 3 hari',
                'poli' => 'umum',
                'queue_time' => now()->format('Y-m-d H:i:s'),
                'status' => 'waiting'
            ],
            [
                'id' => 'Q002',
                'queue_number' => 'A002',
                'patient_name' => 'Siti Nurhaliza',
                'phone_number' => '081234567891',
                'gender' => 'P',
                'age' => 28,
                'complaint' => 'Sakit gigi geraham kiri',
                'poli' => 'gigi',
                'queue_time' => now()->addMinutes(15)->format('Y-m-d H:i:s'),
                'status' => 'in_progress'
            ],
            [
                'id' => 'Q003',
                'queue_number' => 'A003',
                'patient_name' => 'Budi Santoso',
                'phone_number' => '081234567892',
                'gender' => 'L',
                'age' => 42,
                'complaint' => 'Mata merah dan gatal',
                'poli' => 'mata',
                'queue_time' => now()->addMinutes(30)->format('Y-m-d H:i:s'),
                'status' => 'completed'
            ],
            [
                'id' => 'Q004',
                'queue_number' => 'A004',
                'patient_name' => 'Dewi Lestari',
                'phone_number' => '081234567893',
                'gender' => 'P',
                'age' => 30,
                'complaint' => 'Kontrol kehamilan rutin',
                'poli' => 'kandungan',
                'queue_time' => now()->addMinutes(45)->format('Y-m-d H:i:s'),
                'status' => 'waiting'
            ],
            [
                'id' => 'Q005',
                'queue_number' => 'A005',
                'patient_name' => 'Andi Pratama',
                'phone_number' => '081234567894',
                'gender' => 'L',
                'age' => 25,
                'complaint' => 'Checkup kesehatan umum',
                'poli' => 'umum',
                'queue_time' => now()->addHour()->format('Y-m-d H:i:s'),
                'status' => 'waiting'
            ]
        ];

        session(['queues' => $dummyQueues]);
    }

    public function create()
    {
        return view('queue.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'department' => 'required|string',
            'date' => 'required|date',
            'time' => 'required|string',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'age' => 'required|integer|min:1|max:120',
            'complaint' => 'required|string|max:500'
        ]);

        // Get existing queues from session
        $queues = session('queues', []);

        // Generate queue number
        $queueNumber = 'A' . str_pad(count($queues) + 1, 3, '0', STR_PAD_LEFT);

        // Create new queue entry
        $newQueue = [
            'id' => count($queues) + 1,
            'queue_number' => $queueNumber,
            'patient_name' => $request->name,
            'phone_number' => $request->phone,
            'gender' => $request->gender,
            'age' => $request->age,
            'complaint' => $request->complaint,
            'department' => $request->department,
            'queue_time' => $request->date . ' ' . $request->time,
            'status' => 'Menunggu'
        ];

        // Add to queues array
        $queues[] = $newQueue;

        // Save back to session
        session(['queues' => $queues]);

        return response()->json([
            'success' => true,
            'message' => 'Pendaftaran berhasil!',
            'queue_number' => $queueNumber,
            'data' => $newQueue
        ]);
    }



    public function getQueueData()
    {
        $todayQueues = $this->getTodayQueues();

        $currentQueue = null;
        $waitingCount = 0;
        $completedToday = 0;
        $totalToday = count($todayQueues);

        foreach ($todayQueues as $queue) {
            if ($queue['status'] === 'in_progress') {
                $currentQueue = $queue;
            } elseif ($queue['status'] === 'waiting') {
                $waitingCount++;
            } elseif ($queue['status'] === 'completed') {
                $completedToday++;
            }
        }

        // Sort by queue number
        usort($todayQueues, function($a, $b) {
            return $a['queue_number'] <=> $b['queue_number'];
        });

        return response()->json([
            'current_queue' => $currentQueue,
            'waiting_count' => $waitingCount,
            'completed_today' => $completedToday,
            'total_today' => $totalToday,
            'today_queues' => $todayQueues
        ]);
    }
}
