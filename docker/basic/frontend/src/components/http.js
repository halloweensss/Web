import axios from "axios";

export const HTTP = axios.create({
    baseURL: 'http://127.0.0.1:50001/api',
    headers:{
        'Content-Type': 'application/json'
    }
});

export const HTTPData = axios.create({
    baseURL: 'http://127.0.0.1:50001/api',
    headers: {'Content-Type': 'multipart/form-data;charset=utf-8' }
});

export default HTTP;