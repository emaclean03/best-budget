<template>
  <div>
    <Head :title="title"/>
    <Banner/>
    <div>
      <nav class="rounded bg-white">
        <!-- Primary Navigation Menu -->
        <div class="mx-auto px-4 sm:px-6 lg:px-8 ">
          <div class="flex justify-between h-16">
            <div class="flex w-1/2 justify-end items-center mt-2">
              <div class="1/4 rounded-lg p-2 m-2" :class="working_balance.amount >= 0.00 ? 'bg-green-200' : 'bg-red-400'">
                <!--working_balance is coming from HandleInertiaRequets.php                -->
                {{working_balance.formatted}}
              </div>
            </div>
            <div class="flex">
              <!-- Navigation Links -->
              <div class="space-x-8 sm:-my-px sm:ml-10 sm:flex ml-4 mt-3">
                <!--Top nav button-->
              </div>
            </div>

            <div class="sm:flex sm:items-center sm:ml-6 mt-3">
              <!-- Settings Dropdown -->
              <div class="ml-3 relative">
                <Dropdown align="right" width="48">
                  <template #trigger>
                    <button v-if="$page.props.jetstream.managesProfilePhotos"
                            class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                      <img class="h-8 w-8 rounded-full object-cover" :src="$page.props.user.profile_photo_url"
                           :alt="$page.props.user.name">
                    </button>
                    <span v-else class="inline-flex rounded-md">
                                            <button type="button"
                                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition">
                                                {{ $page.props.user.name }}
                                                <svg
                                                    class="ml-2 -mr-0.5 h-4 w-4"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20"
                                                    fill="currentColor"
                                                >
                                                    <path fill-rule="evenodd"
                                                          d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                          clip-rule="evenodd"/>
                                                </svg>
                                            </button>
                                        </span>
                  </template>

                  <template #content>
                    <!-- Account Management -->
                    <div class="block px-4 py-2 text-xs text-gray-400">
                      Manage Account
                    </div>

                    <DropdownLink :href="route('profile.show')">
                      Profile
                    </DropdownLink>

                    <div class="border-t border-gray-100"/>

                    <!-- Authentication -->
                    <form @submit.prevent="logout">
                      <DropdownLink as="button">
                        Log Out
                      </DropdownLink>
                    </form>
                  </template>
                </Dropdown>
              </div>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center hidden ">
              <button
                  class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition"
                  @click="showingNavigationDropdown = ! showingNavigationDropdown">
                <svg
                    class="h-6 w-6"
                    stroke="currentColor"
                    fill="none"
                    viewBox="0 0 24 24"
                >
                  <path
                      :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M4 6h16M4 12h16M4 18h16"
                  />
                  <path
                      :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M6 18L18 6M6 6l12 12"
                  />
                </svg>
              </button>
            </div>
          </div>
        </div>

        <!-- Responsive Navigation Menu -->
        <div :class="{'block': showingNavigationDropdown, 'hidden': !showingNavigationDropdown}" class="sm:hidden">
          <div class="pt-2 pb-3 space-y-1">
            <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
              Dashboard
            </ResponsiveNavLink>
          </div>

          <!-- Responsive Settings Options -->
          <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="flex items-center px-4">
              <div v-if="$page.props.jetstream.managesProfilePhotos" class="shrink-0 mr-3">
                <img class="h-10 w-10 rounded-full object-cover" :src="$page.props.user.profile_photo_url"
                     :alt="$page.props.user.name">
              </div>

              <div>
                <div class="font-medium text-base text-gray-800">
                  {{ $page.props.user.name }}
                </div>
                <div class="font-medium text-sm text-gray-500">
                  {{ $page.props.user.email }}
                </div>
              </div>
            </div>

            <div class="mt-3 space-y-1">
              <ResponsiveNavLink :href="route('profile.show')" :active="route().current('profile.show')">
                Profile
              </ResponsiveNavLink>

              <ResponsiveNavLink v-if="$page.props.jetstream.hasApiFeatures" :href="route('api-tokens.index')"
                                 :active="route().current('api-tokens.index')">
                API Tokens
              </ResponsiveNavLink>

              <!-- Authentication -->
              <form method="POST" @submit.prevent="logout">
                <ResponsiveNavLink as="button">
                  Log Out
                </ResponsiveNavLink>
              </form>

              <!-- Team Management -->
              <template v-if="$page.props.jetstream.hasTeamFeatures">
                <div class="border-t border-gray-200"/>

                <div class="block px-4 py-2 text-xs text-gray-400">
                  Manage Team
                </div>

                <!-- Team Settings -->
                <ResponsiveNavLink :href="route('teams.show', $page.props.user.current_team)"
                                   :active="route().current('teams.show')">
                  Team Settings
                </ResponsiveNavLink>

                <ResponsiveNavLink v-if="$page.props.jetstream.canCreateTeams" :href="route('teams.create')"
                                   :active="route().current('teams.create')">
                  Create New Team
                </ResponsiveNavLink>

                <div class="border-t border-gray-200"/>

                <!-- Team Switcher -->
                <div class="block px-4 py-2 text-xs text-gray-400">
                  Switch Teams
                </div>

                <template v-for="team in $page.props.user.all_teams" :key="team.id">
                  <form @submit.prevent="switchToTeam(team)">
                    <ResponsiveNavLink as="button">
                      <div class="flex items-center">
                        <svg
                            v-if="team.id == $page.props.user.current_team_id"
                            class="mr-2 h-5 w-5 text-green-400"
                            fill="none"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                          <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>{{ team.name }}</div>
                      </div>
                    </ResponsiveNavLink>
                  </form>
                </template>
              </template>
            </div>
          </div>
        </div>
      </nav>
    </div>
    <div class="flex min-h-screen w-full mx-auto bg-gradient-to-r from-indigo-200 to-transparent">
      <div class="w-1/6 h-screen">
        <AppSideBar/>
      </div>
      <div class="w-4/6">
        <!-- Page Content -->
        <main>
          <slot/>
        </main>
      </div>
      <div class="w-1/6 h-screen">
<!--This is the right side nav bar, for if we want to use it in the future-->
<!--        <AppSideBar/>-->
      </div>
    </div>
  </div>
</template>


<script lang="ts" setup>
import {computed, ref} from 'vue';
import { router } from '@inertiajs/vue3'
import {Head, Link, usePage} from '@inertiajs/vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import Banner from '@/Components/Banner.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import AppSideBar from "@/Layouts/AppSideBar.vue";

interface Props {
  title: string,
}

const props = defineProps<Props>();

const showingNavigationDropdown = ref(false);

const accounts = computed(() => usePage().props.accounts);
const working_balance = computed(() => usePage().props.working_balance);



const logout = () => {
  Inertia.post(route('logout'));
};
</script>