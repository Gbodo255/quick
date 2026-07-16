<?php

namespace App\Http\Requests\Dossier;

use App\Enums\FormStep;
use App\Validation\Dossier\StepRulesResolver;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDossierRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $step = FormStep::tryFrom((string) $this->input('step'));

        if (! $step) {
            return [
                'step' => ['required', Rule::enum(FormStep::class)],
            ];
        }

        return array_merge(
            ['step' => ['required', Rule::enum(FormStep::class)]],
            app(StepRulesResolver::class)->for($step)->rules(),
        );
    }

    public function step(): FormStep
    {
        return FormStep::from($this->validated('step'));
    }

    public function stepPayload(): array
    {
        $validated = $this->validated();
        unset($validated['step']);

        return $validated;
    }
}
