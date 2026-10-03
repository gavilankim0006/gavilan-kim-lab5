import axios from "axios";

const baseURL = import.meta.env.VITE_API_URL || "http://localhost:3000";

const api = axios.create({ baseURL });

const ACCESS_KEY = "access_token";
const REFRESH_KEY = "refresh_token";

export const tokenStore = {
  get access() {
    return localStorage.getItem(ACCESS_KEY) || "";
  },
  get refresh() {
    return localStorage.getItem(REFRESH_KEY) || "";
  },
  setTokens(access, refresh) {
    if (access) localStorage.setItem(ACCESS_KEY, access);
    if (refresh) localStorage.setItem(REFRESH_KEY, refresh);
  },
  clear() {
    localStorage.removeItem(ACCESS_KEY);
    localStorage.removeItem(REFRESH_KEY);
  },
};

// Attach the access token to every request.
api.interceptors.request.use((config) => {
  if (tokenStore.access) {
    config.headers.Authorization = `Bearer ${tokenStore.access}`;
  }
  return config;
});

// Refresh once on 401, then retry the original request.
let refreshing = null;

api.interceptors.response.use(
  (response) => response,
  async (error) => {
    const original = error.config;
    const status = error.response?.status;

    // Login endpoint failing is not a refresh opportunity.
    const isAuthRoute = original?.url?.includes("/api/auth/login");

    if (status === 401 && !original._retry && !isAuthRoute && tokenStore.refresh) {
      original._retry = true;

      refreshing =
        refreshing ||
        api
          .post("/api/auth/refresh", { refresh_token: tokenStore.refresh })
          .then(({ data }) => {
            const tokens = data.tokens ?? data;
            tokenStore.setTokens(tokens.access_token, tokens.refresh_token);
            return tokens.access_token;
          })
          .catch((err) => {
            tokenStore.clear();
            window.dispatchEvent(new CustomEvent("auth:logout"));
            throw err;
          })
          .finally(() => {
            refreshing = null;
          });

      try {
        const newToken = await refreshing;
        original.headers.Authorization = `Bearer ${newToken}`;
        return api(original);
      } catch {
        return Promise.reject(error);
      }
    }

    return Promise.reject(error);
  }
);

export default api;
