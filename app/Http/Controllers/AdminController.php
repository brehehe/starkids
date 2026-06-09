<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminController extends Controller
{
    private function getQueues()
    {
        return session('queues', []);
    }

    private function saveQueues($queues)
    {
        session(['queues' => $queues]);
    }

    private function getTodayQueues()
    {
        $queues = $this->getQueues();
        $today = now()->format('Y-m-d');

        return array_filter($queues, function($queue) use ($today) {
            return substr($queue['queue_time'], 0, 10) === $today;
        });
    }

    public function dashboard()
    {
        $todayQueues = $this->getTodayQueues();

        $stats = [
            'waiting' => 0,
            'in_progress' => 0,
            'completed' => 0,
            'cancelled' => 0
        ];

        foreach ($todayQueues as $queue) {
            $stats[$queue['status']]++;
        }

        // Sort by queue number
        usort($todayQueues, function($a, $b) {
            return $a['queue_number'] <=> $b['queue_number'];
        });

        if (!view()->exists('admin.dashboard')) {
            return redirect('/user');
        }

        return view('admin.dashboard', compact('stats', 'todayQueues'));

    }

    public function callNext()
    {
        $queues = $this->getQueues();
        $todayQueues = $this->getTodayQueues();

        // Find next waiting queue
        $nextQueue = null;
        foreach ($todayQueues as $queue) {
            if ($queue['status'] === 'waiting') {
                $nextQueue = $queue;
                break;
            }
        }

        if (!$nextQueue) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada antrian yang menunggu'
            ]);
        }

        // Update queues
        for ($i = 0; $i < count($queues); $i++) {
            // Set current in_progress to completed
            if ($queues[$i]['status'] === 'in_progress' &&
                substr($queues[$i]['queue_time'], 0, 10) === now()->format('Y-m-d')) {
                $queues[$i]['status'] = 'completed';
                $queues[$i]['completed_at'] = now()->toISOString();
            }

            // Set next queue to in_progress
            if ($queues[$i]['id'] === $nextQueue['id']) {
                $queues[$i]['status'] = 'in_progress';
                $queues[$i]['called_at'] = now()->toISOString();
            }
        }

        $this->saveQueues($queues);

        return response()->json([
            'success' => true,
            'message' => "Antrian nomor {$nextQueue['queue_number']} dipanggil!",
            'queue_number' => $nextQueue['queue_number']
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:waiting,in_progress,completed,cancelled'
        ]);

        $queues = $this->getQueues();

        for ($i = 0; $i < count($queues); $i++) {
            if ($queues[$i]['id'] === $id) {
                $queues[$i]['status'] = $request->status;

                if ($request->status === 'in_progress') {
                    $queues[$i]['called_at'] = now()->toISOString();
                } elseif (in_array($request->status, ['completed', 'cancelled'])) {
                    $queues[$i]['completed_at'] = now()->toISOString();
                }

                break;
            }
        }

        $this->saveQueues($queues);

        return response()->json([
            'success' => true,
            'message' => 'Status antrian berhasil diupdate!'
        ]);
    }
}
