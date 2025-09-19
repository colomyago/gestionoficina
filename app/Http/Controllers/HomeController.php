namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto; // Importa el modelo

class HomeController extends Controller
{
    public function index()
    {
        // Trae todos los productos
        $productos = Producto::all();

        // Manda los datos a la vista
        return view('index', compact('productos'));
    }
}