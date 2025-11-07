<?php
    use Filament\Support\Facades\FilamentView;
?>

<!--[if BLOCK]><![endif]--><?php if($this->hasUnsavedDataChangesAlert() && (! FilamentView::hasSpaMode())): ?>
        <?php
        $__scriptKey = '1014089348-0';
        ob_start();
    ?>
        <script>
            window.addEventListener('beforeunload', (event) => {
                if (window.jsMd5(JSON.stringify($wire.data).replace(/\\/g, '')) === $wire.savedDataHash) {
                    return
                }

                event.preventDefault()
                event.returnValue = true
            })
        </script>
        <?php
        $__output = ob_get_clean();

        \Livewire\store($this)->push('scripts', $__output, $__scriptKey)
    ?>
<?php endif; ?><!--[if ENDBLOCK]><![endif]-->
<?php /**PATH D:\Download\vue_pwa\Power app\oid_backend\vendor\filament\filament\resources\views/components/page/unsaved-data-changes-alert.blade.php ENDPATH**/ ?>