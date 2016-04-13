<?php

namespace Fce\Events;

abstract class Event
{
    // Key events.
    const KEY_GIVEN_OUT = 'key.given_out';
    const KEY_USED = 'key.used';

    // Evaluation events.
    const EVALUATION_SUBMITTED = 'evaluation.submitted';

    // Section events.
    const SECTION_OPENED = 'section.opened';
    const SECTION_CLOSED = 'section.closed';

    // Question set events.
    const QUESTION_SET_OPENED = 'question_set.opened';
    const QUESTION_SET_CLOSED = 'question_set.closed';
}
