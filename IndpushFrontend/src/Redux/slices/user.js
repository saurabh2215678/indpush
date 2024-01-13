import { createAsyncThunk, createSlice } from '@reduxjs/toolkit'
import { apiURI } from '../../utils/common'


export const userSignup = createAsyncThunk(
    'user/signup',
    async (formdata) => {
        const response = await fetch(`${apiURI}/signup`, {
            method:'post',
            body: new URLSearchParams(formdata),
            headers: {
               "Content-Type": "application/x-www-form-urlencoded",
               }
        });
        const responseData = await response.json();
        return responseData
      }
);

const localStorageUser = JSON.parse(localStorage.getItem('userData'));

const initialState = {
    user: localStorageUser,
  }


export const userSlice = createSlice({
    name: 'user',
    initialState: initialState,
    reducers: {
        logout(state){
            state.user = null;
            localStorage.removeItem('userData');
        }
    },
   
    extraReducers: (builder) => {
        // fetch builder
       builder.addCase(userSignup.pending, (state, action) => {
         state.loading =  true;
       });
       builder.addCase(userSignup.fulfilled, (state, action) => {
         state.user =  action.payload.user;
         localStorage.setItem('userData', JSON.stringify(action.payload.user));
         state.loading =  false;
         state.error =  false;
       });
       builder.addCase(userSignup.rejected, (state, action) => {
         state.error =  true;
         state.loading =  false;
       });

    }
});

export const { logout } = userSlice.actions
export default userSlice.reducer