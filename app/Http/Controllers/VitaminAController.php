
namespace App\Http\Controllers;

use App\Models\Child;
use App\Models\VitaminARecord;
use Illuminate\Http\Request;

class VitaminAController extends Controller
{
    // Fetch Vitamin A records for a specific child
    public function index(Child $child)
    {
        return response()->json([
            'records' => $child->vitamin_a_supplementations,
        ]);
    }

    // Add a new Vitamin A record for a specific child
    public function store(Request $request, Child $child)
    {
        $validated = $request->validate([
            'age' => 'required|integer',
            'dose' => 'required|string',
            'date' => 'required|date',
        ]);

        $record = new VitaminARecord($validated);
        $record->child_id = $child->id;
        $record->save();

        return response()->json([
            'record' => $record,
        ]);
    }
}