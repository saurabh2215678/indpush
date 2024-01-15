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
        const apiStatus = response.status;
        const responseData = await response.json();
        return {...responseData, status: apiStatus}
      }
);
export const userLogin = createAsyncThunk(
    'user/login',
    async (formdata) => {
        const response = await fetch(`${apiURI}/login`, {
            method:'post',
            body: new URLSearchParams(formdata),
            headers: {
               "Content-Type": "application/x-www-form-urlencoded",
               }
        });
        const apiStatus = response.status;
        const responseData = await response.json();
        return {...responseData, status: apiStatus}
      }
);

export const verifyOtp = createAsyncThunk(
  'user/verify-otp',
  async (formdata) => {
      const response = await fetch(`${apiURI}/verify-otp`, {
          method:'post',
          body: new URLSearchParams(formdata),
          headers: {
             "Content-Type": "application/x-www-form-urlencoded",
             }
      });
      const apiStatus = response.status;
      const responseData = await response.json();
      return {...responseData, status: apiStatus}
    }
);

export const resendOtp = createAsyncThunk(
  'user/resend-otp',
  async (formdata) => {
      const response = await fetch(`${apiURI}/resend-otp`, {
          method:'post',
          body: new URLSearchParams(formdata),
          headers: {
             "Content-Type": "application/x-www-form-urlencoded",
             }
      });
      const apiStatus = response.status;
      const responseData = await response.json();
      return {...responseData, status: apiStatus}
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
        if(action.payload.user){
            state.user =  action.payload.user;
            localStorage.setItem('userData', JSON.stringify(action.payload.user));
        }
         state.loading =  false;
         state.error =  false;
       });
       builder.addCase(userSignup.rejected, (state, action) => {
         state.error =  true;
         state.loading =  false;
       });


        builder.addCase(userLogin.pending, (state, action) => {
          state.loading =  true;
        });
        builder.addCase(userLogin.fulfilled, (state, action) => {
        if(action.payload.user){
            state.user =  action.payload.user;
            localStorage.setItem('userData', JSON.stringify(action.payload.user));
        }
          state.loading =  false;
          state.error =  false;
        });
        builder.addCase(userLogin.rejected, (state, action) => {
          state.error =  true;
          state.loading =  false;
        });

        builder.addCase(verifyOtp.pending, (state, action) => {
          state.loading =  true;
        });
        builder.addCase(verifyOtp.fulfilled, (state, action) => {
          state.loading =  false;
          state.error =  false;
        });
        builder.addCase(verifyOtp.rejected, (state, action) => {
          state.error =  true;
          state.loading =  false;
        });

        builder.addCase(resendOtp.pending, (state, action) => {
          state.loading =  true;
        });
        builder.addCase(resendOtp.fulfilled, (state, action) => {
          state.loading =  false;
          state.error =  false;
        });
        builder.addCase(resendOtp.rejected, (state, action) => {
          state.error =  true;
          state.loading =  false;
        });

    }
});

export const { logout } = userSlice.actions
export default userSlice.reducer