<template>
    <div class="pagination" v-if="totalPages > 0">
        <ButtonComponent class="page-btn" :disabled="!hasPreviousPage" @click="onPageChange(currentPage - 1)"
            label="« Anterior" :show-icon="false" />

        <div class="page-numbers">
            <ButtonComponent class="page-number" :class="{ active: currentPage === 1 }" @click="onPageChange(1)"
                label="1" :show-icon="false" />

            <h1 v-if="currentPage > 4">...</h1>
            <ButtonComponent v-for="page in displayedPageNumbers" :key="page" class="page-number"
                :class="{ active: currentPage === page }" @click="onPageChange(page)" :label="page.toString()"
                :show-icon="false" />

            <h1 v-if="currentPage < totalPages - 3">...</h1>

            <ButtonComponent v-if="totalPages > 1" class="page-number" :class="{ active: currentPage === totalPages }"
                @click="onPageChange(totalPages)" :label="totalPages.toString()" :show-icon="false" />
        </div>

        <ButtonComponent class="page-btn" :disabled="!hasNextPage" @click="onPageChange(currentPage + 1)"
            label="Próxima »" :show-icon="false" />
    </div>
</template>

<script lang="ts">
import ButtonComponent from './ButtonComponent.vue';

export default {
    name: 'PaginationComponent',
    components: {
        ButtonComponent
    },
    props: {
        currentPage: {
            type: Number,
            required: true
        },
        totalPages: {
            type: Number,
            required: true
        },
        hasNextPage: {
            type: Boolean,
            required: true
        },
        hasPreviousPage: {
            type: Boolean,
            required: true
        }
    },
    computed: {
        displayedPageNumbers() {
            const current = this.currentPage;
            const last = this.totalPages;
            const pages = [];

            for (let i = Math.max(2, current - 1); i <= Math.min(last - 1, current + 1); i++) {
                pages.push(i);
            }

            return pages;
        }
    },
    methods: {
        onPageChange(page: number) {
            this.$emit('page-change', page);
        }
    }
}
</script>

<style scoped>
.pagination {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0px 8px;
    gap: 5px;
}

.page-numbers {
    display: flex;
    align-items: center;
    margin: 0 10px;
    gap: 5px;
}

.page-btn {
    min-width: 100px;
}

.page-number {
    min-width: 40px;
    padding: 0;
}

.page-number.active {
    background-color: var(--persian-blue-700);
}


</style>