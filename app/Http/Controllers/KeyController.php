<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\RoomKey;
use Picqer\Barcode\BarcodeGeneratorHTML;
use Picqer\Barcode\BarcodeGeneratorPNG;

class KeyController extends Controller
{
    // Tampilkan daftar kunci
    public function index()
    {
        $keys = RoomKey::with('room')->paginate(20);
        return view('keys.index', compact('keys'));
    }

    // Generate / Regenerate barcode kunci
    public function regenerate(Room $room)
    {
        $key = $room->key;

        $barcodeText = 'RM-' . $room->room_number . '-' . strtoupper(uniqid());

        if (!$key) {
            $key = RoomKey::create([
                'room_id' => $room->id,
                'barcode' => $barcodeText
            ]);
        } else {
            $key->update(['barcode' => $barcodeText]);
        }

        return back()->with('success', 'Barcode kunci berhasil diperbarui untuk kamar ' . $room->room_number);
    }

    // Scan kunci via form input
    public function scan(Request $request)
    {
        $request->validate(['barcode' => 'required|string']);

        $key = RoomKey::with('room')->where('barcode', $request->barcode)->first();

        if (!$key || !$key->room) {
            return response()->json([
                'success' => false,
                'message' => 'Barcode kunci tidak valid atau tidak ditemukan'
            ], 404);
        }

        // Update status room menjadi available
        $key->room->update(['status' => 'available']);

        // Log aktivitas scan
        \Log::info('Key scanned', [
            'barcode' => $request->barcode,
            'room' => $key->room->room_number,
            'admin' => auth()->check() ? auth()->user()->name : 'Unknown'
        ]);

        return response()->json([
            'success' => true,
            'message' => "Kunci kamar {$key->room->room_number} berhasil di-scan. Kamar siap digunakan.",
            'room' => $key->room
        ]);
    }

    // Generate barcode HTML untuk tampil di blade
    public function showBarcode(RoomKey $key)
    {
        $generator = new BarcodeGeneratorHTML();
        $barcodeHTML = $generator->getBarcode($key->barcode, $generator::TYPE_CODE_128);

        return view('keys.show', compact('key', 'barcodeHTML'));
    }

    // Download barcode sebagai PNG
    public function downloadBarcode(RoomKey $key)
    {
        $generator = new BarcodeGeneratorPNG();
        $barcodeData = $generator->getBarcode($key->barcode, $generator::TYPE_CODE_128);

        return response($barcodeData)
            ->header('Content-Type', 'image/png')
            ->header('Content-Disposition', 'attachment; filename="barcode-' . $key->room->room_number . '.png"');
    }

    // Generate multiple barcodes untuk print
    public function printBarcodes()
    {
        $keys = RoomKey::with('room')->get();
        $generator = new BarcodeGeneratorHTML();

        $barcodes = $keys->map(function ($key) use ($generator) {
            return [
                'key' => $key,
                'html' => $generator->getBarcode($key->barcode, $generator::TYPE_CODE_128, 2, 60)
            ];
        });

        return view('keys.print', compact('barcodes'));
    }
}