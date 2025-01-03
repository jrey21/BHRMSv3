
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Child extends Model
{
    use HasFactory;

    // ...existing code...

    // Define the relationship with VitaminARecord
    public function vitamin_a_supplementations()
    {
        return $this->hasMany(VitaminARecord::class);
    }

    // ...existing code...
}