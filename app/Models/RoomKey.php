<?php
// app/Models/RoomKey.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RoomKey extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'barcode',
        'is_active',
        'generated_at',
        'last_scanned_at',
        'scanned_by'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'generated_at' => 'datetime',
        'last_scanned_at' => 'datetime'
    ];

    // Relationship dengan Room
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    // User yang terakhir scan
    public function scannedBy()
    {
        return $this->belongsTo(User::class, 'scanned_by');
    }

    // Generate barcode unik
    public static function generateUniqueBarcode($roomNumber)
    {
        do {
            $barcode = 'RM-' . $roomNumber . '-' . strtoupper(substr(md5(uniqid()), 0, 8));
        } while (self::where('barcode', $barcode)->exists());

        return $barcode;
    }

    // Update scan activity
    public function markAsScanned($userId = null)
    {
        $this->update([
            'last_scanned_at' => now(),
            'scanned_by' => $userId ?? auth()->id()
        ]);
    }
}
