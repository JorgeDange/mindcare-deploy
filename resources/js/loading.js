var submitInProgress = false;

document.addEventListener('submit', function (e) {
    var form = e.target;
    if (!form || !form.tagName || form.tagName !== 'FORM') return;
    if (submitInProgress) return;

    var noLoading = form.hasAttribute('data-no-loading');
    if (noLoading) return;

    var submitter = e.submitter;
    var btn = submitter || form.querySelector('[type="submit"]');

    submitInProgress = true;

    if (btn && !btn.hasAttribute('data-no-loading')) {
        btn.classList.add('btn-loading');
        btn.disabled = true;
    }

    if (typeof window.showLoading === 'function') {
        window.showLoading('A processar...');
    }
});

window.addEventListener('pageshow', function () {
    submitInProgress = false;
    if (typeof window.hideLoading === 'function') {
        window.hideLoading();
    }
    document.querySelectorAll('.btn-loading').forEach(function (el) {
        el.classList.remove('btn-loading');
        el.disabled = false;
    });
});