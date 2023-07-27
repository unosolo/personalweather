import { ref } from "vue";
import { defineStore } from "pinia";
import { useConfigStore } from "@/stores/configStore";
import type { UserDto } from "@/dto/UserDto";

export const useUserListStore = defineStore("userList", () => {
  const { api } = useConfigStore();

  async function fetchUsers(): Promise<void> {
    return await (await fetch(`${api}/users`)).json();
  }

  return {
    fetchUsers,
  };
});
