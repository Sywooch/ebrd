<?php

namespace frontend\modules\blog\interfaces;

interface Publishable {
	const STATUS_DRAFT = 1;
	const STATUS_UNPUBLISHED = 3;
	const STATUS_FOR_CONFIRMATION = 7;
	const STATUS_PUBLISHED = 11;
	const STATUS_REJECTED_BY_PUBLISHER = 13;
	const STATUS_TRASH = 17;
}
