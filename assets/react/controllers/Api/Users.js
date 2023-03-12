const url = 'http://localhost:8000/admin/user';

export const getUsers = async () => {

    try {
        const response = await fetch(url);
        const data = await response.json();
        return data;
    } catch (error) {
        console.log(error);
    }
    
   
};