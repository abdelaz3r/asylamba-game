<?php
include_once DEMETER;

$id = Utils::getHTTPData('id');

if ($id) {
	$_TOM = ASM::$tom->getCurrensession();
	ASM::$tom->load(array('id' => $id));
	if (CTR::$data->get('playerInfo')->get('status') > 2)) {
		if (ASM::$tom->get()->isUp = 1) {
			ASM::$tom->get()->isUp = 0;
		} else {
			$rForum = ASM::$tom->get()->rForum;
			ASM::$tom->get()->isUp = 1;
			$_TOM2 = ASM::$tom->getCurrensession();
			ASM::$tom->load(array('isUp' => 1, 'rForum' => $rForum));

			if (ASM::$tom->size() > 0) {
				ASM::$tom->isUp = 0;
			}
			ASM::$tom->changeSession($_TOM2);
		}
	}
	ASM::$tom->changeSession($_TOM);
	CTR::redirect('faction/view-forum/forum-' . $topic->rForum . '/topic-' . ASM::$tom->id . '/sftr-2');
} else {
	CTR::$alert->add('Manque d\information.', ALERT_STD_FILLFORM);
}