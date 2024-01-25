<template>
    <div class="w-full relative min-h-screen justify-center bg-white overflow-hidden bg-gray-50">
        <div class="w-full mx-auto px-4 md:px-6 py-24 flex justify-center">
            <div class="inline-flex flex-wrap justify-center bg-slate-200 rounded-[20px] p-1 mb-8">
                <button @click="currentTab(1)" class="flex-1 text-sm font-medium h-8 px-4 rounded-2xl whitespace-nowrap focus-visible:outline-none ui-focus-visible:outline-none ui-focus-visible:ring ui-focus-visible:ring-indigo-300 transition-colors duration-150 ease-in-out bg-white text-slate-900" type="button">Lassen Peak</button>
                <button @click="currentTab(2)" class="flex-1 text-sm font-medium h-8 px-4 rounded-2xl whitespace-nowrap focus-visible:outline-none ui-focus-visible:outline-none ui-focus-visible:ring ui-focus-visible:ring-indigo-300 transition-colors duration-150 ease-in-out text-slate-900" type="button">Lassen Peak</button>
                <button @click="currentTab(3)" class="flex-1 text-sm font-medium h-8 px-4 rounded-2xl whitespace-nowrap focus-visible:outline-none ui-focus-visible:outline-none ui-focus-visible:ring ui-focus-visible:ring-indigo-300 transition-colors duration-150 ease-in-out text-slate-900" type="button">Lassen Peak</button>
            </div>
        </div>

        <div>
            <div class="container mx-auto">

                <div class="p-3 mt-6 bg-white border">

                    <div v-if="tab === 1">
                        Tab 1 Content show Lorem ipsum dolor sit amet consectetur adipisicing
                        elit. Quas sunt ducimus numquam! Quam, perspiciatis!
                    </div>

                    <div v-if="tab === 2">
                        Tab 2 Content show Lorem ipsum dolor sit amet consectetur, adipisicing
                        elit. aliquam rem. Exercitationem corporis eius voluptatibus.
                    </div>

                    <div v-if="tab === 3">
                        Tab 3 Content show Lorem ipsum dolor sit amet consectetur adipisicing
                        elit.
                    </div>

                </div>
            </div>
        </div>


    </div>
</template>


<script>
export default {
    data() {
        return {
            tab: 1,
        };
    },
    methods: {
        currentTab: function (tabNumber) {
            this.tab = tabNumber;
        },
    },
};
</script>
