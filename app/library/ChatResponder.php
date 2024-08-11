<?php
namespace app\library;

use XArray;

/**
 * A mock responder class, provides random responses.
 */
class ChatResponder {
    const TEXT = 'Etiam in diam ex. Aenean eu leo nec purus vulputate gravida. Fusce pellentesque dignissim gravida. Cras faucibus pretium urna, nec tincidunt metus dapibus vitae. Morbi convallis ornare interdum. Donec eleifend dui diam, at accumsan metus accumsan eget. Pellentesque a velit eleifend, gravida sem eget, porttitor urna. Morbi sed urna pretium massa mollis bibendum. Integer non ante interdum, porta ligula sit amet, fringilla eros. Praesent congue mollis lorem. Nunc placerat nisi risus, vitae consectetur tortor consequat et. Phasellus cursus enim ante, in consequat eros vehicula ut. Ut auctor, lacus eu facilisis lacinia, risus metus blandit ipsum, vitae volutpat felis mi at ex. Nulla eu molestie tortor. Suspendisse potenti. Praesent lobortis, mi quis commodo mollis, nunc ex viverra nisi, sit amet aliquam magna velit id ipsum.';

    /**
     * Choose a random phrase.
     */
    static function respond(): string {
        return XArray::fromSplit('.', self::TEXT)
            ->map('trim')->shuffle()
            ->first() . '.';
    }
}
