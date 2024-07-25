window.addEventListener('DOMContentLoaded', async () => {
    const cr_burger = await import("./modules/burger.js");

    cr_burger.burger();
})