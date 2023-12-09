<script setup>
import { Link } from '@inertiajs/vue3';
import route from '../route';
</script>

<template>
    <div class="common-layout">
        <el-container>
            <el-header>
                <Link :href="route('home')" class="app-name">
                    {{ $page.props.appName }}
                </Link>
            </el-header>
            <el-main>
                <slot />
            </el-main>
        </el-container>
    </div>
</template>

<style scoped>
.el-header {
    display: flex;
    align-items: center;
}

.app-name {
    font-size: var(--el-font-size-extra-large);
    color: inherit;
    text-decoration: none;
}

.app-name:hover {
    color: var(--el-color-primary);
}
</style>
