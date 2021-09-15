<?php

/**
 * Reload an ajax loaded HTML element.
 *
 * @param  string|array  $id  HTML element identifier
 * @return string jQuery call
 */
function reloadAjaxContent($id): string
{
    if (gettype($id) == 'array') {
        $response = '';
        foreach ($id as $i) {
            $response .= "reloadAjaxLoadContent('#$i');";
        }

        return $response;
    } else {
        return "reloadAjaxLoadContent('#$id');";
    }
}

/**
 * Reload deferred ajax loaded HTML element.
 *
 * @param  string|array  $id  HTML element identifier
 * @return string jQuery call
 */
function reloadDeferredAjaxContent($id): string
{
    if (gettype($id) == 'array') {
        $response = '';
        foreach ($id as $i) {
            $response .= "loadDeferredAjaxLoadContent('#$i');";
        }

        return $response;
    } else {
        return "loadDeferredAjaxLoadContent('#$id');";
    }
}

/**
 * Close an ajax loaded window.
 *
 * @return string
 */
function closeModal(): string
{
    return '$("#modaldis .modal-header .close").last().click();';
}

/**
 * Simulate an element click.
 *
 * @param  string  $id
 * @return string
 */
function clickElement(string $id): string
{
    return '$("#'.$id.'").click();';
}

/**
 * Fire an ajax modal loading event.
 *
 * @param  string  $link
 * @return string
 */
function loadAjaxModalLink(string $link): string
{
    return "loadAjaxModalLink('{$link}');";
}

/**
 * Close a custom box modal.
 *
 * @return string
 */
function closeCustombox(): string
{
    return 'Custombox.modal.close();';
}
