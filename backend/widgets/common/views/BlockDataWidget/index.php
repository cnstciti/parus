<?php
/**
 * @var array $params
 *
 */

?>
<div class="card <?= $params['class'] ?>">
    <div class="card-header <?= $params['header']['class'] ?>">
        <div class="row">
            <div class="col-9">

                <?= $params['header']['title'] ?>

            </div>
            <div class="col-3 text-right">

                <a id="<?= $params['header']['button']['id'] ?>" class="<?= $params['header']['button']['class'] ?>" data-target="<?= $params['header']['button']['action'] ?>">
                    <span id="fa-icon-<?= $params['header']['button']['id'] ?>" class="fas <?= $params['header']['button']['icon'] ?>" title="<?= $params['header']['button']['title'] ?>"></span>
                </a>

            </div>
        </div>
    </div>
    <div class="card-body">

        <?= $params['content'] ?>

    </div>
</div>
