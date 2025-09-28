namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PengantarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $pengantarId = null;
        
        // Get the pengantar ID for update operations
        if ($this->route() && $this->route()->parameter('pengantar')) {
            $pengantarId = $this->route()->parameter('pengantar');
            // If it's a model instance
            if (is_object($pengantarId)) {
                $pengantarId = $pengantarId->id;
            }
        }

        return [
            'resident_id' => 'required|exists:residents,id',
            'name' => 'required|string|max:255',
            'NIK' => [
                'required',
                'string',
                'size:16',
                Rule::unique('pengantar')->ignore($pengantarId)
            ],
            'purpose' => 'required|string|max:500',
            'date' => 'required|date|after_or_equal:today'
        ];
    }
}