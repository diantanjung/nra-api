<?php

namespace App\Transformers;

use App\Models\OtpToken;
use League\Fractal\TransformerAbstract;

class OtpTokenTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param  \App\Models\OtpToken  $user_archive
     * @return array
     */
    public function transform(OtpToken $otp_token): array
    {
        return [
            'id'            => (int) $otp_token->id,
            'user_id'       => (int) $otp_token->user_id,
            'archive_id'    => (int) $otp_token->archive_id,
            'archive_label' => (string) $otp_token->master->name,
            'attachment'    => (string) $otp_token->attachment,
        ];
    }
}
