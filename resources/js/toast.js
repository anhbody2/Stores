export function showToast(message, redirectUrl = null) {
    const toast = document.createElement("div");
    toast.className = "global-toast";
    toast.innerText = message;

    document.body.appendChild(toast);

    setTimeout(() => toast.classList.add("show"), 50);

    setTimeout(() => {
        toast.classList.remove("show");
        setTimeout(() => {
            toast.remove();
            if (redirectUrl) window.location.href = redirectUrl;
        }, 300);
    }, 2000);
}
