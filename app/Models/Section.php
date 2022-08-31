<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Section extends Model
{
    use HasFactory;

    protected $fillable=['name'];

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function options(): HasMany
    {
        return $this->hasMany(ClasseOption::class);
    }

    public function getInscriptionCount($id){
        $inscriptions=Student::select('students.id','inscriptions.')
            ->join('classes','students.classe_id','=','classes.id')
            ->join('classe_options','classes.classe_option_id','=','classe_options.id')
            ->join('sections','classe_options.section_id','=','sections.id')
            ->where('sections.id',$id)
            ->with('option')
            ->with('classe')
            ->count();
        return $inscriptions;
    }
}
