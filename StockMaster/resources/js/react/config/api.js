// centralized API configuration
const API_BASE_URL = '/api';

export const API_ROUTES = {
    // Auth
    LOGIN: `${API_BASE_URL}/login`,
    REGISTER: `${API_BASE_URL}/register`,
    LOGOUT: `${API_BASE_URL}/logout`,
    FORGOT_PASSWORD: `${API_BASE_URL}/forgot-password`,
    USER: `${API_BASE_URL}/user`,

    // Dashboard
    DASHBOARD_STATS: `${API_BASE_URL}/dashboard-stats`,
};

export default API_ROUTES;
