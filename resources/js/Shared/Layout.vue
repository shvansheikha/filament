<template>

    <Head>
        <title>TITLE</title>
    </Head>

    <div class="flex flex-col justify-between bg-white min-h-screen">

        <main class="mb-auto relative">
            <div class="flex w-full justify-center">
                <div class="flex w-full justify-between">
                    <slot/>
                </div>
            </div>
        </main>
    </div>
</template>

<script>

export default {
    name: "Layout",
}
</script>
